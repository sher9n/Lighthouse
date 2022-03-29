"use strict";
const Web3Modal = window.Web3Modal.default;
const WalletConnectProvider = window.WalletConnectProvider.default;
const evmChains = window.evmChains;

let web3Modal
let provider;
let selectedAccount;
let page = 0;
let loading = 0;
let change_network = 0;
let add_nw_wallet = 0;
let route;

function init() {
    const providerOptions = {
        walletconnect: {
            package: WalletConnectProvider,
            options: {
                infuraId: "4ff5dfbfe8734cc7b295b70eb203dccc",
            }
        }
    };

    web3Modal = new Web3Modal({
        cacheProvider: false, // optional
        providerOptions, // required
        disableInjectedProvider: false, // optional. For MetaMask / Brave / Opera.
    });
}

async function fetchAccountData() {
    // Get a Web3 instance for the wallet
    const web3 = new Web3(provider);

    // Get connected chain id from Ethereum node
    const chainId = await web3.eth.getChainId();

    $('.btn_connect').addClass('d-none');
    $('.wallet_disconnected').addClass('d-none');
    $('.wallet_connected').removeClass('d-none');
    // Load chain information over an HTTP API

    const chainData = evmChains.getChain(chainId);
    // Get list of accounts of the connected wallet

    const accounts = await web3.eth.getAccounts();
    // MetaMask does not give you all accounts, only the selected account

    selectedAccount = accounts[0];

    if (selectedAccount) {
        var display_address = selectedAccount.substring(0, 6) + '...' + selectedAccount.slice(-4);
        sessionStorage.setItem("lh_sel_wallet_add", selectedAccount);
        document.querySelector("#user_address").textContent = display_address;
        $('#user_avatar').removeClass('d-none');
        document.querySelector("#user_key").value = selectedAccount;

        if (sessionStorage.getItem('lh_wallet_adds')) {
            var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
            if (jQuery.inArray(selectedAccount, lh_wallet_adds) == -1) {
                lh_wallet_adds.push(selectedAccount);
                sessionStorage.setItem("lh_wallet_adds", JSON.stringify(lh_wallet_adds));
            }
        } else {
            sessionStorage.setItem("lh_wallet_adds", JSON.stringify([selectedAccount]));
        }

        updateWalletMenu();
        //getFirstCoinsPage();
        $("#navbarMain").removeClass('fade');
        $('#user_menu').removeClass('d-none');

    } else {
        $('#user_menu').addClass('d-none');
        onDisconnect();
    }

    if(route == 'claims')
        getClaims();
    else if (route == 'drops')
        getDrops();
}

async function checkAccountData() {

    selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");
    var url_parts = document.location.pathname.split('/');
    route = url_parts[url_parts.length-1];

    if (selectedAccount) {
        var display_address = selectedAccount.substring(0, 6) + '...' + selectedAccount.slice(-4);
        $('#user_avatar').removeClass('d-none');
        document.querySelector("#user_address").textContent = display_address;
        $('#user_avatar').removeClass('d-none');
        document.querySelector("#user_key").value = selectedAccount;

        $('.btn_connect').addClass('d-none');
        $('.wallet_disconnected').addClass('d-none');
        $('.wallet_connected').removeClass('d-none');

        if (sessionStorage.getItem('lh_wallet_adds')) {
            var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
            if (jQuery.inArray(selectedAccount, lh_wallet_adds) == -1) {
                lh_wallet_adds.push(selectedAccount);
                sessionStorage.setItem("lh_wallet_adds", JSON.stringify(lh_wallet_adds));
                $('#wl_con_success').modal('toggle');
            }
        } else
            sessionStorage.setItem("lh_wallet_adds", JSON.stringify([selectedAccount]));

        updateWalletMenu();
        updateUser();
        $("#navbarMain").removeClass('fade');
        $('#user_menu').removeClass('d-none');

    } else {
        $('.btn_connect').removeClass('d-none');
        $('.wallet_disconnected').removeClass('d-none');
        $('.wallet_connected').addClass('d-none');
        $('#user_menu').addClass('d-none');
    }

    if(route == 'claims')
        getClaims();
    else if (route == 'drops')
        getDrops();
}

async function updateWalletMenu() {
    var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
    var sel_wallet_add = sessionStorage.getItem('lh_sel_wallet_add');
    var data = {'adds': lh_wallet_adds, 'sel_add': sel_wallet_add};

    $.ajax({
        url: 'wallet-menu',
        dataType: 'json',
        data: data,
        type: 'POST',
        success: function (response) {
            if (response.success == true) {
                $('#wallet_addresses').html(response.html);
            }
        }
    });
}

async function getClaims() {
    var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
    var sel_wallet_add = sessionStorage.getItem('lh_sel_wallet_add');
    var data = {'adds': lh_wallet_adds, 'sel_add': sel_wallet_add};

    $.ajax({
        url: 'get_claims',
        dataType: 'json',
        data: data,
        type: 'POST',
        success: function (response) {
            if (response.success == true) {
                $('#connected_claims').html(response.html);
            }
        }
    });
}

async function getDrops() {
    var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
    var sel_wallet_add = sessionStorage.getItem('lh_sel_wallet_add');
    var data = {'adds': lh_wallet_adds, 'sel_add': sel_wallet_add};

    $.ajax({
        url: 'get-drops',
        dataType: 'json',
        data: data,
        type: 'POST',
        success: function (response) {
            if (response.success == true) {
                $('#drops_cards').html(response.html);
            }
        }
    });
}

async function updateUser() {
    var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
    var sel_wallet_add = sessionStorage.getItem('lh_sel_wallet_add');
    var data = {'adds': lh_wallet_adds, 'sel_add': sel_wallet_add};

    $.ajax({
        url: 'update-user',
        dataType: 'json',
        data: data,
        type: 'POST'
    });
}

async function addWallet() {

    try {
        provider = await web3Modal.connect();
    } catch (e) {
        return;
    }
    add_nw_wallet = 1;
    await fetchAccountData();
}

async function onConnect() {

    try {
        provider = await web3Modal.connect();
    } catch (e) {
        return;
    }
    // Subscribe to accounts change
    provider.on("accountsChanged", (accounts) => {
        fetchAccountData();
    });

    // Subscribe to chainId change
    provider.on("chainChanged", (chainId) => {
        change_network = 1;
        fetchAccountData();
    });

    // Subscribe to networkId change
    provider.on("networkChanged", (networkId) => {
        change_network = 1;
        fetchAccountData();
    });

    await fetchAccountData();
}

async function onDisconnect() {
    sessionStorage.removeItem('lh_sel_wallet_add');
    sessionStorage.removeItem('lh_wallet_adds');
    document.querySelector("#user_key").value = '';
    document.querySelector("#user_address").textContent = '';
    $('#user_avatar').addClass('d-none');
    $('#user_menu').addClass('d-none');
    //getFirstCoinsPage();
    $("#navbarMain").addClass('fade');

    $('.btn_connect').removeClass('d-none');
    $('.wallet_disconnected').removeClass('d-none');
    $('.wallet_connected').addClass('d-none');

    if (provider && provider.close) {
        await provider.close();
        await web3Modal.clearCachedProvider();
        provider = null;
    }
    selectedAccount = null;
}

window.addEventListener('load', async () => {
    init();
    //document.querySelector("#btn-connect").addEventListener("click", onConnect);
});

$(document).on("click",".delete_wallet",function(e) {
    e.preventDefault();
    var ele = $(this);
    var w_id = ele.data("w_id");
    var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));

    if(jQuery.inArray(w_id, lh_wallet_adds) != -1){
        lh_wallet_adds = jQuery.grep(lh_wallet_adds, function(value) {
            return value != w_id;
        });
        if(lh_wallet_adds.length == 0) {
            onDisconnect();
        }
        else {
            sessionStorage.setItem("lh_sel_wallet_add", lh_wallet_adds[0]);
            sessionStorage.setItem("lh_wallet_adds", JSON.stringify(lh_wallet_adds));
            selectedAccount = null;
        }
        updateWalletMenu();
    }
});
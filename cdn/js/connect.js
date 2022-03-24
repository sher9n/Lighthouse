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

    const web3 = new Web3(provider);

    const chainId = await web3.eth.getChainId();

    if (chainId == 1) {
        const chainData = evmChains.getChain(chainId);
        const accounts  = await web3.eth.getAccounts();
        selectedAccount = accounts[0];
        change_network  = 0;
        $('body').removeClass('alert-view');
        $('#network_check').addClass('fade');
        $('#btn-connect').prop('disabled', false);

        if (selectedAccount) {
            var display_address = selectedAccount.substring(0, 6) + '...' + selectedAccount.slice(-4);
            sessionStorage.setItem("lh_sel_wallet_add", selectedAccount);
            document.querySelector("#connected_wl_id").textContent = display_address;
            document.querySelector("#selected-account").textContent = display_address;
            document.querySelector("#user_address").textContent = display_address;
            document.querySelector("#user_key").value = selectedAccount;
            $('.user_details_skelton').addClass('d-none');
            $('.user_details').removeClass('d-none');

            if (sessionStorage.getItem('lh_wallet_adds')) {
                var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));

                if (jQuery.inArray(selectedAccount, lh_wallet_adds) == -1) {
                    lh_wallet_adds.push(selectedAccount);
                    sessionStorage.setItem("lh_wallet_adds", JSON.stringify(lh_wallet_adds));
                }
            }
            else {
                sessionStorage.setItem("lh_wallet_adds", JSON.stringify([selectedAccount]));
            }

            updateWalletMenu();
            getFirstCoinsPage();
            $("#navbarMain").removeClass('fade');
            $('#user_menu').removeClass('d-none');
            $('#Welcome').modal('hide');
        } else {
            $('#user_menu').addClass('d-none');
            onDisconnect();
        }
    } else {
        if (!sessionStorage.getItem('lh_wallet_adds')) {
            $('#Welcome').modal('show');
            $('#btn-connect').prop('disabled', true);
            $('#network_check').removeClass('fade');
        } else if (change_network == 0 && add_nw_wallet == 1) {
            $('#Welcome').modal('show');
            $('#btn-connect').prop('disabled', true);
            $('#network_check').removeClass('fade');
            $('.user_details_skelton').addClass('d-none');
            $('.user_details').removeClass('d-none');
        } else {
            $('#Welcome').modal('hide');
            $('body').addClass('alert-view');
            $('.user_details_skelton').addClass('d-none');
            $('.user_details').removeClass('d-none');
        }
    }
}

async function checkAccountData() {
    selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");

    if (selectedAccount) {
        var display_address = selectedAccount.substring(0, 6) + '...' + selectedAccount.slice(-4);
        document.querySelector("#connected_wl_id").textContent = display_address;
        document.querySelector("#selected-account").textContent = display_address;
        document.querySelector("#user_address").textContent = display_address;
        document.querySelector("#user_key").value = selectedAccount;
        $('.user_details_skelton').addClass('d-none');
        $('.user_details').removeClass('d-none');

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
    } else
        $('#user_menu').addClass('d-none');
    getFirstCoinsPage();
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

async function refreshAccountData() {
    fetchAccountData(provider);
}

async function addWallet() {
    try {
        provider = await web3Modal.connect();
    } catch (e) {
        return;
    }
    add_nw_wallet = 1;
    await refreshAccountData();
}

async function onConnect() {
    $('#Welcome').modal('toggle');

    try {
        provider = await web3Modal.connect();
    } catch (e) {
        return;
    }

    provider.on("accountsChanged", (accounts) => {
        fetchAccountData();
    });

    provider.on("chainChanged", (chainId) => {
        change_network = 1;
        fetchAccountData();
    });

    provider.on("networkChanged", (networkId) => {
        change_network = 1;
        fetchAccountData();
    });

    await refreshAccountData();
}

async function onDisconnect() {
    sessionStorage.removeItem('lh_sel_wallet_add');
    sessionStorage.removeItem('lh_wallet_adds');
    document.querySelector("#user_key").value = '';
    document.querySelector("#selected-account").textContent = '';
    //document.querySelector("#user_address").textContent = '';
    $('#user_menu').addClass('d-none');
    getFirstCoinsPage();
    $('#Welcome').modal('toggle');
    $("#navbarMain").addClass('fade');
    $('.user_details_skelton').removeClass('d-none');
    $('.user_details').addClass('d-none');

    if (provider && provider.close) {
        await provider.close();
        await web3Modal.clearCachedProvider();
        provider = null;
    }
    selectedAccount = null;
}

window.addEventListener('load', async () => {
    init();
    document.querySelector("#btn-connect").addEventListener("click", onConnect);
});
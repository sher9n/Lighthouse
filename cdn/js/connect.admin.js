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

    // Load chain information over an HTTP API

    const chainData = evmChains.getChain(chainId);
    // Get list of accounts of the connected wallet

    const accounts = await web3.eth.getAccounts();
    // MetaMask does not give you all accounts, only the selected account

    selectedAccount = accounts[0];

    if (selectedAccount) {
        sessionStorage.setItem("lh_sel_wallet_add", selectedAccount);

        if (sessionStorage.getItem('lh_wallet_adds')) {
            var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
            if (jQuery.inArray(selectedAccount, lh_wallet_adds) == -1) {
                lh_wallet_adds.push(selectedAccount);
                sessionStorage.setItem("lh_wallet_adds", JSON.stringify(lh_wallet_adds));
            }
        }
        else
            sessionStorage.setItem("lh_wallet_adds", JSON.stringify([selectedAccount]));

        updateWalletMenu();
    }
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
                window.location = 'admin-dashboard';
            }
        }
    });
}

async function checkAccountData() {
    selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");
    document.querySelector("#sel_wallet_address").innerHTML = selectedAccount;
}

async function addWallet() {
    try {
        $("#AdminCenter").modal('hide');
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

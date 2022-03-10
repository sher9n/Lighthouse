"use strict";
const Web3Modal = window.Web3Modal.default;
const WalletConnectProvider = window.WalletConnectProvider.default;
const evmChains = window.evmChains;

let web3Modal
let provider;
let selectedAccount;
let page = 0;
let loading = 0;

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

  console.log("Web3Modal instance is", web3Modal);
}

async function fetchAccountData() {

  // Get a Web3 instance for the wallet
  const web3 = new Web3(provider);
  if(provider.chainId == 1) {
    $('body').removeClass('alert-view');
    console.log(provider.chainId);
    // Get connected chain id from Ethereum node
    const chainId = await web3.eth.getChainId();
    // Load chain information over an HTTP API
    const chainData = evmChains.getChain(chainId);
    // Get list of accounts of the connected wallet
    const accounts = await web3.eth.getAccounts();
    // MetaMask does not give you all accounts, only the selected account
    selectedAccount = accounts[0];

    if (selectedAccount) {
      var display_address = selectedAccount.substring(0, 6) + '...' + selectedAccount.slice(-4);
      sessionStorage.setItem("lh_sel_wallet_add", selectedAccount);
      document.querySelector("#connected_wl_id").textContent = display_address;
      $('#wl_con_success').modal('toggle');
      document.querySelector("#selected-account").textContent = display_address;
      document.querySelector("#user_address").textContent = display_address;
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

      $("#navbarMain").removeClass('fade');
      updateWalletMenu();
      getFirstCoinsPage();
    } else
      onDisconnect();
  }
  else {
    onDisconnect();
    $('body').addClass('alert-view');
  }

}

async function checkAccountData() {

  selectedAccount = sessionStorage.getItem("lh_sel_wallet_add");

  if(selectedAccount) {
    var display_address = selectedAccount.substring(0, 6) + '...' + selectedAccount.slice(-4);
    document.querySelector("#connected_wl_id").textContent = display_address;
    document.querySelector("#selected-account").textContent = display_address;
    document.querySelector("#user_address").textContent = display_address;
    document.querySelector("#user_key").value = selectedAccount;

    $('user_menu').removeClass('d-none');
    if (sessionStorage.getItem('lh_wallet_adds')) {
      var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
      if (jQuery.inArray(selectedAccount, lh_wallet_adds) == -1) {
        lh_wallet_adds.push(selectedAccount);
        sessionStorage.setItem("lh_wallet_adds", JSON.stringify(lh_wallet_adds));
      }
    } else
      sessionStorage.setItem("lh_wallet_adds", JSON.stringify([selectedAccount]));

    updateWalletMenu();
    updateUser();
    $("#navbarMain").removeClass('fade');
  }
  else
    $('user_menu').addClass('d-none');
  getFirstCoinsPage();
}

async function updateWalletMenu() {
  var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
  var sel_wallet_add = sessionStorage.getItem('lh_sel_wallet_add');
  var data = {'adds':lh_wallet_adds,'sel_add':sel_wallet_add};

  $.ajax({
    url: 'wallet-menu',
    dataType: 'json',
    data: data,
    type: 'POST',
    success: function(response) {
      if (response.success == true) {
        $('#wallet_addresses').html(response.html);
      }
    }
  });
}

async function updateUser() {
  var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
  var sel_wallet_add = sessionStorage.getItem('lh_sel_wallet_add');
  var data = {'adds':lh_wallet_adds,'sel_add':sel_wallet_add};

  $.ajax({
    url: 'update-user',
    dataType: 'json',
    data: data,
    type: 'POST'
  });
}

async function refreshAccountData() {
  //document.querySelector("#btn-connect").setAttribute("disabled", "disabled")
  fetchAccountData(provider);
  //document.querySelector("#btn-connect").removeAttribute("disabled")
}

async function addWallet() {

  try {
      provider = await web3Modal.connect();
  }
  catch (e) {
    return;
  }

  // Subscribe to accounts change
  provider.on("accountsChanged", (accounts) => {
    fetchAccountData();
  });

  // Subscribe to chainId change
  provider.on("chainChanged", (chainId) => {
    fetchAccountData();
  });

  // Subscribe to networkId change
  provider.on("networkChanged", (networkId) => {
    fetchAccountData();
  });

  await refreshAccountData();
}

async function onConnect() {

  $('#Welcome').modal('toggle');

  try {
      provider = await web3Modal.connect();
  }
  catch (e) {
    return;
  }
  // Subscribe to accounts change
  provider.on("accountsChanged", (accounts) => {
    fetchAccountData();
  });

  // Subscribe to chainId change
  provider.on("chainChanged", (chainId) => {
    fetchAccountData();
  });

  // Subscribe to networkId change
  provider.on("networkChanged", (networkId) => {
    fetchAccountData();
  });

  $('#wallet_connect_success').removeClass('fade');
  await refreshAccountData();
}

async function onDisconnect() {
  sessionStorage.removeItem('lh_sel_wallet_add');
  sessionStorage.removeItem('lh_wallet_adds');
  document.querySelector("#user_key").value = '';
  document.querySelector("#selected-account").textContent = '';
  document.querySelector("#user_address").textContent = '';
  getFirstCoinsPage();
  $('#Welcome').modal('toggle');
  $("#navbarMain").addClass('fade');

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
"use strict";

const Web3Modal = window.Web3Modal.default;
const WalletConnectProvider = window.WalletConnectProvider.default;
const evmChains = window.evmChains;

let web3Modal

let provider;

let selectedAccount;

function init() {
  const providerOptions = {
    walletconnect: {
      package: WalletConnectProvider,
      options: {
        // Mikko's test key - don't copy as your mileage may vary
        //infuraId: "8043bb2cf99347b1bfadfb233c5325c0",
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
  // Get connected chain id from Ethereum node
  const chainId = await web3.eth.getChainId();
  // Load chain information over an HTTP API
  const chainData = evmChains.getChain(chainId);
  document.querySelector("#network-name").textContent = chainData.name;

  // Get list of accounts of the connected wallet
  const accounts = await web3.eth.getAccounts();

  // MetaMask does not give you all accounts, only the selected account
  selectedAccount = accounts[0];
  var display_address = selectedAccount.substring(0, 6) +'...'+selectedAccount.slice(-4);
  document.querySelector("#selected-account").textContent = display_address;
  document.querySelector("#user_address").textContent = display_address;
  document.querySelector("#user_key").value = selectedAccount;
  $("#navbarMain").removeClass('fade');
  getFirstCoinsPage();
}

async function refreshAccountData() {
  document.querySelector("#btn-connect").setAttribute("disabled", "disabled")
  fetchAccountData(provider);
  document.querySelector("#btn-connect").removeAttribute("disabled")
}

async function onConnect() {
  $('#Welcome').modal('toggle');

  try {
      provider = await web3Modal.connect();
  } catch(e) {
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

async function onDisconnect() {
  document.querySelector("#user_key").value = '';
  document.querySelector("#selected-account").textContent = '';
  document.querySelector("#user_address").textContent = '';
  getFirstCoinsPage();
  $('#Welcome').modal('toggle');
  $("#navbarMain").addClass('fade');

  if(provider.close) {
    await provider.close();
    await web3Modal.clearCachedProvider();
    provider = null;
  }
  selectedAccount = null;
}

window.addEventListener('load', async () => {
  init();
  document.querySelector("#btn-connect").addEventListener("click", onConnect);
  document.querySelector("#btn-disconnect").addEventListener("click", onDisconnect);
});
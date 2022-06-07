let selectedAccount;

async function addWallet() {
    $("#AdminCenter").modal('show');
}

async function changeWallet(pop=false) {

    if(pop == true)
        $("#sendNewNttPop").modal('hide');

    $('#admin_wallet').modal('show');

    if(pop == true)
        $('#sendNewNttPop').modal('show');
}

async function connectToEth(blockchain='gnosis_chain'){
    console.log('connecting metamask.........');
    const provider = new ethers.providers.Web3Provider(window.ethereum, "any");
    await provider.send("eth_requestAccounts", []);
    const signer = provider.getSigner();
    const network = await provider.getNetwork();

    selectedAccount = await signer.getAddress();

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

        $('#wallet').modal('hide');
        updateAdminSession();
    }

    switchNetwork(blockchain);
}

function connectToWCEth(blockchain='gnosis_chain'){

    //An infura ID, or custom ETH node is required for Ethereum, for Binance Smart Chain you can just use their public endpoint
    var provider = new WalletConnectProvider.default(
        {
            infuraId: "4ff5dfbfe8734cc7b295b70eb203dccc",
            rpc: {56: "https://bsc-dataseed.binance.org/"}
        });

    provider.enable().then(function(res){
        let web3 = new Web3(provider);
        selectedAccount = provider.accounts[0];

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

            $('#wallet').modal('hide');
            updateAdminSession();
           // switchNetwork(blockchain);
        }
    });
}

async function changeToEth(){
    console.log('connecting metamask.........');
    const provider = new ethers.providers.Web3Provider(window.ethereum, "any");
    await provider.send("eth_requestAccounts", []);
    const signer = provider.getSigner();
    const network = await provider.getNetwork();

    selectedAccount = await signer.getAddress();

    if (selectedAccount) {
        document.querySelector("#wallet_address").value = selectedAccount;
        $("#admin_wallet").modal('hide');
        $("#sendNewNttPop").modal('show');
    }
}

function changeToWCEth(){

    //An infura ID, or custom ETH node is required for Ethereum, for Binance Smart Chain you can just use their public endpoint
    var provider = new WalletConnectProvider.default(
        {
            infuraId: "4ff5dfbfe8734cc7b295b70eb203dccc",
            rpc: {56: "https://bsc-dataseed.binance.org/"}
        });

    provider.enable().then(function(res){
        let web3 = new Web3(provider);
        selectedAccount = provider.accounts[0];

        if (selectedAccount) {
            document.querySelector("#wallet_address").value = selectedAccount;
            $("#admin_wallet").modal('hide');
            $("#sendNewNttPop").modal('show');
        }
    });
}

async function updateAdminSession() {

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
            else {
                sessionStorage.removeItem('lh_sel_wallet_add');
                sessionStorage.removeItem('lh_wallet_adds');
                $('#whitelist_error').removeClass('d-none');
                $("#AdminCenter").modal('show');
            }
        }
    });
}

function switchNetwork(blockchain) {
    if(blockchain != 'gnosis_chain') {
        window.ethereum.request({
            method: 'wallet_addEthereumChain',
            params: [{
                chainId: '0x45', //69
                chainName: 'Optimism Kovan',
                nativeCurrency: {
                    name: 'KOR',
                    symbol: 'KOR',
                    decimals: 18
                },
                rpcUrls: ['https://kovan.optimism.io/'],
                blockExplorerUrls: ['https://kovan-optimistic.etherscan.io']
            }]
        }).catch((error) => {
            console.log(error)
        });
    }
    else{
        window.ethereum.request({
            method: 'wallet_addEthereumChain',
            params: [{
                chainId: '0x4D', //77
                chainName: 'POA Sokol Testnet',
                nativeCurrency: {
                    name: 'SPOA',
                    symbol: 'SPOA',
                    decimals: 18
                },
                rpcUrls: ['https://sokol.poa.network/'],
                blockExplorerUrls: ['https://sokol.poa.network']
            }]
        }).catch((error) => {
            console.log(error)
        });
    }
}

async function onDisconnect() {
    sessionStorage.removeItem('lh_sel_wallet_add');
    sessionStorage.removeItem('lh_wallet_adds');
    localStorage.clear();
    selectedAccount = null;
}
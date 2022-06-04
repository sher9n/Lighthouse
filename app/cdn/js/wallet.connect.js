let selectedAccount;

async function connectToEth(){
    console.log('connecting metamask.........');
    const provider = new ethers.providers.Web3Provider(window.ethereum, "any");
    await provider.send("eth_requestAccounts", []);
    const signer = provider.getSigner();
    const network = await provider.getNetwork();

    selectedAccount = await signer.getAddress();

    if (selectedAccount) {
        sessionStorage.setItem("lh_sel_wallet_add", selectedAccount);
        //document.querySelector("#sel_wallet_address").innerHTML = selectedAccount;
        document.querySelector("#wallet_address").value = selectedAccount;
        document.querySelector("#add_wallet").innerHTML = 'CHANGE WALLET';

        if (sessionStorage.getItem('lh_wallet_adds')) {
            var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
            if (jQuery.inArray(selectedAccount, lh_wallet_adds) == -1) {
                lh_wallet_adds.push(selectedAccount);
                sessionStorage.setItem("lh_wallet_adds", JSON.stringify(lh_wallet_adds));
            }
        } else {
            sessionStorage.setItem("lh_wallet_adds", JSON.stringify([selectedAccount]));
        }

        $('#wallet').modal('hide');
    }

    switchNetwork();
}


function connectToWCEth(){

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
            //document.querySelector("#sel_wallet_address").innerHTML = selectedAccount;
            document.querySelector("#wallet_address").value = selectedAccount;
            document.querySelector("#add_wallet").innerHTML = 'CHANGE WALLET';

            if (sessionStorage.getItem('lh_wallet_adds')) {
                var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
                if (jQuery.inArray(selectedAccount, lh_wallet_adds) == -1) {
                    lh_wallet_adds.push(selectedAccount);
                    sessionStorage.setItem("lh_wallet_adds", JSON.stringify(lh_wallet_adds));
                }
            } else {
                sessionStorage.setItem("lh_wallet_adds", JSON.stringify([selectedAccount]));
            }
            $('#wallet').modal('hide');
        }
    });
}

function switchNetwork() {
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
    })
        .catch((error) => {
            console.log(error)
        })
}

async function onDisconnect() {
    sessionStorage.removeItem('lh_sel_wallet_add');
    sessionStorage.removeItem('lh_wallet_adds');
    localStorage.clear();
    selectedAccount = null;
}
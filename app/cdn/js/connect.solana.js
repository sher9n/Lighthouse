
const getProvider = async () => {
    if ("solana" in window) {
        await window.solana.connect(); // opens wallet to connect to
        const provider = window.solana;
        return provider;
    } else {
        console.log("No Solana wallet detected. Redirecting to Phantom.");
        window.open("https://www.phantom.app/", "_blank");
    }};

function getSolanaAccount() {

    getProvider().then(provider => {
        if(provider) {
            selectedAccount = provider.publicKey.toString();
            sessionStorage.setItem("lh_sel_wallet_add", selectedAccount);
            //document.querySelector("#sel_wallet_address").innerHTML = selectedAccount;
            document.querySelector("#wallet_address").value = selectedAccount;
            //document.querySelector("#add_wallet").innerHTML = 'CHANGE WALLET';
            
            if (sessionStorage.getItem('lh_wallet_adds')) {
                var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
                if (jQuery.inArray(selectedAccount, lh_wallet_adds) == -1) {
                    lh_wallet_adds.push(selectedAccount);
                    sessionStorage.setItem("lh_wallet_adds", JSON.stringify(lh_wallet_adds));
                }
            }
            else
                sessionStorage.setItem("lh_wallet_adds", JSON.stringify([selectedAccount]));

            $('#selectChain').modal('hide');
            $('#setupCommunity').modal('show');
        }
    }).catch(function(error) {
            console.log(error)
    });
}

async function addSolanaWallet() {
    $("#AdminCenter").modal('hide');
    $('#AdminPhantom').modal('show');
}

function disconnectAccount() {

    window.solana.request({
        method: "disconnect"
    });

    window.solana.on('disconnect', () => {
        console.log("Solana Wallet Disconnected!");
    });
}

async function realmTransaction(response) {

    const txns = response.createRealmSerializedTxn.map((txn) =>
        solanaWeb3.Transaction.from(txn.data)
    );

    var provider = await getProvider();

    const signedTxns = await provider.signAllTransactions(txns);

    var connection = getConnection();

    for (let signedTxn of signedTxns) {
        const sig = await solanaWeb3.sendAndConfirmRawTransaction(
            connection,
            signedTxn.serialize()
        );
        //console.log(sig);
    }

    for (let tx of response.createCommunitySerializedTxn) {
        const sig2 = await solanaWeb3.sendAndConfirmRawTransaction(
            connection,
            tx.data
        );
        //console.log(sig2);
    }

}

const getConnection = () => {
    const connection = new solanaWeb3.Connection(solanaWeb3.clusterApiUrl("devnet"), "confirmed");
    return connection;
};

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
            else {
                sessionStorage.removeItem('lh_sel_wallet_add');
                sessionStorage.removeItem('lh_wallet_adds');
                $('#whitelist_solana_error').removeClass('d-none');
            }
        }
    });
}
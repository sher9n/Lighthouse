
const getProvider = async (solflare) => {
    if(solflare==true){
        if ("solflare" in window) {
            await window.solflare.connect();
            const provider = window.solflare;
            return provider;
        }
        else
            window.open("https://solflare.com/", "_blank");
    }
    else
    {
        if ("solana" in window) {
            await window.solana.connect();
            const provider = window.solana;
            return provider;
        }
        else
            window.open("https://www.phantom.app/", "_blank");
    }
};

function getSolanaAccount(solflare=false) {

    getProvider(solflare).then(provider => {
        if(provider) {
            selectedAccount = provider.publicKey.toString();
            sessionStorage.setItem("lh_sel_wallet_add", selectedAccount);
            document.querySelector("#wallet_address").value = selectedAccount;
            
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

/*** ------------START REALMS TRANSACTIONS JS-----------------*/
async function realmTransaction(response,url) {

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

    window.location.replace(url);
}


async function realmProposalTransaction(response) {

    const txns = response.serializedTxns.map((txn) =>
        solanaWeb3.Transaction.from(txn.data)
    );

    var provider = await getProvider();

    const signedTxns = await provider.signAllTransactions(txns);

    var connection = getConnection();

    showMessage('success', 10000, 'Initiating and Writing transactions...');
    for (let signedTxn of signedTxns) {
        const sig = await solanaWeb3.sendAndConfirmRawTransaction(
            connection,
            signedTxn.serialize()
        );
    }
    showMessage('success', 10000, 'Finalizing the transaction...');
    return true;
}

const getConnection = () => {
    const connection = new solanaWeb3.Connection(solanaWeb3.clusterApiUrl("devnet"), "confirmed");
    return connection;
};
/*** ------------END REALMS TRANSACTIONS JS-----------------*/

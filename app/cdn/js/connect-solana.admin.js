
const getProvider = async () => {

    if(sessionStorage.getItem('lh_wallet') && sessionStorage.getItem('lh_wallet')=='solflare'){
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

function changeSolanaAccount() {
    getProvider().then(provider => {
        if(provider) {
            selectedAccount = provider.publicKey.toString();
            document.querySelector("#wallet_address").value = selectedAccount;
        }
    }).catch(function(error) {
        console.log(error)
    });
}

window.solana.on('accountChanged', (publicKey) => {
    if (publicKey) {
        selectedAccount = publicKey.toBase58();
        $("#login_wallet_adr").html(selectedAccount.substring(0,6)+'...'+selectedAccount.substring(selectedAccount.length-4));
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
    else {
        disconnectWallet();
    }
});

async function getSolanaAccount (solflare=false){

    update = false;

    if(solflare==true)
        sessionStorage.setItem("lh_wallet",'solflare');
    else
        sessionStorage.setItem("lh_wallet",'phantom');

    getProvider().then(provider => {
        if(provider) {
            selectedAccount = provider.publicKey.toString();
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

            return true;
        }
    });
}

const checkSolanaAccount = async () => {

    update = false;

    var provider = await getProvider();

    if(provider) {
        selectedAccount = provider.publicKey.toString();

        if(sessionStorage.getItem('lh_sel_wallet_add') != selectedAccount) {
            update = true;
            showMessage('warning', 10000, 'Changing the wallet...');
            sessionStorage.removeItem('lh_wallet_adds');
            sessionStorage.setItem("lh_sel_wallet_add", selectedAccount);
        }

        if (sessionStorage.getItem('lh_wallet_adds')) {
            var lh_wallet_adds = JSON.parse(sessionStorage.getItem('lh_wallet_adds'));
            if (jQuery.inArray(selectedAccount, lh_wallet_adds) == -1) {
                lh_wallet_adds.push(selectedAccount);
                sessionStorage.setItem("lh_wallet_adds", JSON.stringify(lh_wallet_adds));
            }
        }
        else
            sessionStorage.setItem("lh_wallet_adds", JSON.stringify([selectedAccount]));

        if(update == true)
            updateWalletMenu(false);

        if(update == false)
            return true;
        else
            return false;
    }
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
        sessionStorage.removeItem('lh_wallet_role');
        sessionStorage.removeItem('lh_sel_wallet_add');
        sessionStorage.removeItem('lh_wallet_adds');
        window.location = 'admin';
    });
}

async function solanaProposalTransaction(proposalResponse) {
    const txn        = solanaWeb3.Transaction.from(proposalResponse.serializedTxn);
    var provider     = await getProvider();
    var connection   = getConnection();
    const signedTxn  = await provider.signTransaction(txn);
    const sig        = await solanaWeb3.sendAndConfirmRawTransaction(connection,signedTxn.serialize());
    return sig;
}

async function realmProposalTransaction(relResponse) {

    const txns = relResponse.serializedTxns.map((txn) =>
        solanaWeb3.Transaction.from(txn.data)
    );

    var provider = await getProvider();

    const signedTxns = await provider.signAllTransactions(txns);

    var connection = getConnection();

    showMessage('success', 10000, 'Creating a new proposal...');
    const results = [];
    for (let signedTxn of signedTxns) {
        const sig = await solanaWeb3.sendAndConfirmRawTransaction(
            connection,
            signedTxn.serialize()
        );
        results.push(sig);
    }
    return results;
}

const getConnection = () => {
    const connection = new solanaWeb3.Connection(solanaWeb3.clusterApiUrl("devnet"), "confirmed");
    return connection;
};

async function updateWalletMenu(login=true) {
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
                sessionStorage.setItem("lh_wallet_role",response.user_role);
                if(login != true)
                    location.reload();
                else
                    window.location = 'contribution';
            }
            else {
                sessionStorage.removeItem('lh_wallet_role');
                sessionStorage.removeItem('lh_sel_wallet_add');
                sessionStorage.removeItem('lh_wallet_adds');
                $('#whitelist_solana_error').removeClass('d-none');
            }
        }
    });
}
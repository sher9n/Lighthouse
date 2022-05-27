
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
        sessionStorage.removeItem('lh_sel_wallet_add');
        sessionStorage.removeItem('lh_wallet_adds');
        window.location = 'admin';
    });
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
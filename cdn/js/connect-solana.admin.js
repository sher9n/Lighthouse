
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
            console.log('key', provider.publicKey.toString());
            document.getElementById("account").innerHTML = provider.publicKey.toString();
        }
    })
        .catch(function(error) {
            console.log(error)
        });
}

function disconnectAccount() {

    window.solana.request({
        method: "disconnect"
    });
    window.solana.on('disconnect', () => {
        console.log("Solana Wallet Disconnected!");
    });
}
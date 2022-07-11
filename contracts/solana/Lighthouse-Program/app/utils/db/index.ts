import admin from "firebase-admin";
const serviceAccount = {
  type: "service_account",
  project_id: "lighthouse-poc-f75f9",
  private_key_id: "e8bd410de0b7183221806c6e8a530e1ad2d0af7b",
  privateKey: process.env.NEXT_PUBLIC_DB_PK
    ? process.env.NEXT_PUBLIC_DB_PK.replace(/\\n/g, "\n")
    : undefined,
  client_email:
    "firebase-adminsdk-3swfl@lighthouse-poc-f75f9.iam.gserviceaccount.com",
  client_id: "102928781642801279503",
  auth_uri: "https://accounts.google.com/o/oauth2/auth",
  token_uri: "https://oauth2.googleapis.com/token",
  auth_provider_x509_cert_url: "https://www.googleapis.com/oauth2/v1/certs",
  client_x509_cert_url:
    "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-3swfl%40lighthouse-poc-f75f9.iam.gserviceaccount.com",
};
if (!admin.apps.length) {
  try {
    admin.initializeApp({
      credential: admin.credential.cert(serviceAccount),
    });
  } catch (error) {
    console.log("Firebase admin initialization error", error as string);
  }
}
export default admin.firestore();

// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getAuth } from "firebase/auth";

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyD-vi8_vjEGkhoKHyUolms6V3kQSboHIr0",
  authDomain: "viralpost-d4d25.firebaseapp.com",
  projectId: "viralpost-d4d25",
  storageBucket: "viralpost-d4d25.firebasestorage.app",
  messagingSenderId: "845658250755",
  appId: "1:845658250755:web:fbbb4d773c3ba6b7dab836",
  measurementId: "G-3KHR8N8RZS"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const auth = getAuth(app);

export { app, analytics, auth }; 
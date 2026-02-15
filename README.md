# Payment Orchestration Platform (Comp - PAY)

A modular **payment integration platform** built with **Laravel** that enables third-party applications (merchants) to integrate multiple payment providers through a unified API.

This system supports:

- 🔐 Merchant onboarding & API key management  
- 🏦 Direct Bank / FPX instant payments  
- 🔁 Auto Debit / Direct Debit (Mandate & Consent flow)  
- 💳 Multi-provider architecture (currently 2C2P, expanding to Curlec and others)  
- 📡 Real-time payment status updates via Server-Sent Events  

---

## 🚀 Overview

This application acts as a **payment gateway orchestration layer**.

Instead of merchants integrating directly with multiple providers (2C2P, Curlec, banks, etc.), they integrate **once** with this platform.

The platform handles:
- Provider abstraction
- Consent / mandate creation
- Instant payments (FPX / Direct Debit)
- Recurring auto-debit processing
- Webhooks & event streaming
- Secure merchant isolation

---

## 🧩 Supported & Planned Providers

### ✅ Implemented
- **2C2P**
  - FPX payments
  - Direct debit
  - Mandate / consent handling

### 🚧 Planned
- Curlec
- Direct bank integrations
- Additional regional payment providers

The architecture is designed to easily plug in new providers via a **driver-based abstraction layer**.

---

## 👤 Merchant Use Case

### 1️⃣ Merchant Registration

External applications register as a **Merchant** and receive:
- `public_key`
- `secret_key`
- webhook configuration

These keys are used to authenticate all API requests.

---

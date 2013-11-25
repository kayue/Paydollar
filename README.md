# PayDollar Server Side Direct Connection

This library implements PayDollar's [Server Side Direct Connection](http://www.paydollar.com/pdf/paygate_integration_guide.pdf)

**Library is still working in progress.**

## Requirement

For merchant who chooses this method of connection, 128-bit SSL cert must be installed for data encryption. **The system does not accept non-encrypted data.**

PayDollar use Extended Validation (EV) SSL Certificate. To ensure your system function properly, please check your certificate store can recognize VeriSign intermediate CA certificate - Secure Site Pro/Managed PKI for SSL Premium with EV Certificates. If not, you are required to install the VeriSign intermediate CA certificate in your certificate store.

Please download the primary and secondary VeriSign EV SSL Intermediate CA certificates from the following link then import the 2 certificates into the keystore of your environment.

http://www.verisign.com/support/verisign-intermediate-ca/extended-validation-pro/index.html (Please be reminded that you should choose the option “Issued After May 17th, 2009”)

## Todo

* Handle server response
* Unit testing

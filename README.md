# PayDollar library for Payum

This library implements [PayDollar PayGate](http://www.paydollar.com/pdf/paygate_integration_guide.pdf) system.

**This library is still working in progress.**

## Connection Methods

### Client Post Through Browser

This method is requried by 99BILL, ALIPAY, CHINAPAY, PayPal, PPS and TENPAY transaction.

### Direct Client Side Connection

This method is used for the merchant if they want to capture the credit card information from their web page instead of using PayDollar standard payment page. This connection method only apply to credit card transaction.

### Server Side Direct Connection

This connection method is for merchant to request payment authorization from bank directly through PayDollar PayGate system. In this connection, merchants need to build their own payment information collection page to collect payment information, such as credit card number, expire data, holder’s name and etc. Then, payment information has to be sent to a defined URL provided by the acquiring bank. Customer of the merchant, therefore, will not see any bank’s payment page.

#### Requirements

For merchant who chooses this method of connection, 128-bit SSL cert must be installed for data encryption. **The system does not accept non-encrypted data.**

PayDollar use Extended Validation (EV) SSL Certificate. To ensure your system function properly, please check your certificate store can recognize VeriSign intermediate CA certificate - Secure Site Pro/Managed PKI for SSL Premium with EV Certificates. If not, you are required to install the VeriSign intermediate CA certificate in your certificate store.

Please download the primary and secondary VeriSign EV SSL Intermediate CA certificates from the following link then import the 2 certificates into the keystore of your environment.

http://www.verisign.com/support/verisign-intermediate-ca/extended-validation-pro/index.html (Please be reminded that you should choose the option “Issued After May 17th, 2009”)

## Todo

* Client Post Through Browser, should be quite similar to Direct Client Side Connection.
* Status action
* Unit testing

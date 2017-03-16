# Configuration

The bundle comes with some predefined services that makes sending e-mails easier.

#### Driver
For sending the actual email, a driver is configured automatically. 
If you have installed the (optional) [mailer-swiftmailer](https://github.com/cleentfaar/mailer-swiftmailer) package, 
the Swiftmailer engine will be used by default. 

If you choose not to install the [mailer-swiftmailer](https://github.com/cleentfaar/mailer-swiftmailer) package or 
would like to use your own driver, you need to configure the bundle to do so:

```yaml
# app/config/config.yml
cl_mailer:
    driver: 'your_driver_service_id_here'
    # or...
    driver: 'Your\Driver\Class\Here'
```

>**NOTE**: Your driver must implement the `DriverInterface` class.

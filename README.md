# ApiLogger Module

## Overview
The **ApiLogger** module for Magento 2 is designed to log API requests and responses, helping developers monitor and debug API interactions. This version is fully optimized for PHP 8.3 and utilizes strict typing along with modern PHP features to ensure robust performance and maintainability.

## Features
- **Strict Typing:** Uses `declare(strict_types=1);` to enforce strict types throughout the module.
- **PHP 8.3 Compatibility:** Leverages PHP 8.3 features including typed properties, `readonly` properties, and `match` expressions.
- **Structured Logging:** Logs API requests and responses in a structured JSON format, making it easier to analyze log data.
- **Enhanced Exception Handling:** Robust error handling to gracefully manage logging failures.
- **Modular Design:** Easily extendable and configurable to suit your specific needs.

## Installation
1. **Copy the Module:**
    - Place the `ApiLogger` folder into your Magento `app/code/` directory.

2. **Enable the Module:**
    - Open a terminal in the Magento root directory and run:
      ```bash
      bin/magento module:enable ApiLogger
      bin/magento setup:upgrade
      bin/magento cache:flush
      ```

3. **Verify Installation:**
    - Ensure the module is enabled by running:
      ```bash
      bin/magento module:status ApiLogger
      ```

## Configuration
- **Logging Settings:**
    - You can configure the module's settings via the Magento Admin Panel under **Stores > Configuration > ApiLogger**.
- **Log File Location:**
    - API logs are stored in `var/log/apilogger.log`. Ensure the log file is writable by the web server.

## Usage
- The module automatically intercepts API requests and responses, logging them according to your configuration.
- Customize the logging behavior by modifying the classes under `Model/Logger/` as needed.

## Development
- This module uses PHP 8.3 features and strict typing to improve reliability and maintainability.
- Follow Magento's coding standards when making modifications.
- Contributions and feedback are welcome.

## Compatibility
- **Magento Version:** Magento 2.4+
- **PHP Version:** PHP 8.3

## License
*(Include your license information here)*

## Support
For issues, feature requests, or further assistance, please open an issue on our GitHub repository or contact our support team.


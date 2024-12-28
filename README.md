# Magento 2 Custom Increment ID Module

This Magento 2 module, **Custom Increment ID**, allows you to customize increment IDs for invoices and credit memos. You can set unique prefixes and ensure IDs are unique across the system. This module is ideal for businesses that require tailored invoice and credit memo numbering for compliance or branding purposes.

## Features
- Add custom prefixes for invoice and credit memo increment IDs.
- Ensure IDs are unique.
- Fully configurable via the Magento admin panel.

## Installation

### Via Composer
1. Add the repository to your `composer.json` file (if not using Packagist):
   ```json
   {
       "repositories": [
           {
               "type": "vcs",
               "url": "https://github.com/<your-github-username>/magento-custom-increment-id"
           }
       ]
   }
   ```
2. Run the following commands:
   ```bash
   composer require laith/custom-increment-id
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento cache:flush
   ```

### Manual Installation
1. Download the module from GitHub or Packagist.
2. Copy the contents to `app/code/Laith/CustomIncrementId` in your Magento installation.
3. Run the following commands:
   ```bash
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento cache:flush
   ```

## Configuration

1. Log in to the Magento Admin Panel.
2. Navigate to `Stores > Configuration > Laith Integration > Custom Increment ID`.
3. Configure the following options:
   - **Enable Custom Increment ID**: Enable or disable the module.
   - **Order Prefix**: Set a custom prefix for order increment IDs.
   - **Invoice Prefix**: Set a custom prefix for invoice increment IDs.
   - **Credit Memo Prefix**: Set a custom prefix for credit memo increment IDs.

## Usage

- After enabling and configuring the module, any new invoices or credit memos will have increment IDs prefixed with the values you configure.
- The module ensures that all IDs are unique.

## Requirements
- Magento 2.4.x
- PHP 7.4 or PHP 8.0+

## Compatibility
Tested on:
- Magento 2.4.6

## Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature-name`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/your-feature-name`).
5. Create a Pull Request.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

## Support

For support, please open an issue in the [GitHub repository](https://github.com/laithalmasri991/CustomIncrementId) or email the author at laith.k.m4@gmail.com.

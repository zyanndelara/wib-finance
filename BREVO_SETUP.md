# Brevo Email Setup Guide

This guide will help you set up Brevo (formerly Sendinblue) for sending auto-generated passwords to new members.

## Prerequisites

1. A Brevo account (Sign up at https://www.brevo.com/)
2. Verified sender email address in Brevo

## Setup Instructions

### Step 1: Create a Brevo Account

1. Go to https://www.brevo.com/
2. Sign up for a free account
3. Verify your email address

### Step 2: Get Your SMTP Credentials

1. Log in to your Brevo account
2. Go to **Settings** → **SMTP & API**
3. Click on **SMTP** tab
4. You will find:
   - **SMTP Server**: `smtp-relay.brevo.com`
   - **Port**: `587` (recommended) or `465` (SSL)
   - **Login**: Your Brevo account email
   - **SMTP Key**: Click "Generate a new SMTP key" if you don't have one

### Step 3: Verify Sender Email

1. Go to **Settings** → **Senders & IPs**
2. Add and verify your sender email (e.g., `noreply@wibsystem.com`)
3. Follow the verification process (you may need to add DNS records)

### Step 4: Update Environment Configuration

Update your `.env` file with the following Brevo SMTP settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=your_brevo_login_email@example.com
MAIL_PASSWORD=your_brevo_smtp_key_here
MAIL_FROM_ADDRESS="noreply@wibsystem.com"
MAIL_FROM_NAME="Wibsystem"
```

**Important Notes:**
- `MAIL_USERNAME` is your Brevo account email
- `MAIL_PASSWORD` is the SMTP key (NOT your account password)
- `MAIL_FROM_ADDRESS` must be a verified sender email in Brevo
- Keep your SMTP key secure and never commit it to version control

### Step 5: Clear Configuration Cache

After updating `.env`, clear the configuration cache:

```bash
php artisan config:clear
```

### Step 6: Test Email Sending

You can test if email is working by adding a new member in the Member Management section. The system will:
1. Auto-generate a secure password
2. Create the user account
3. Send a welcome email with login credentials

## Email Features

The welcome email includes:
- User's full name and employee ID
- Login email
- Auto-generated password
- Security warnings and best practices
- Direct login link
- Professional branding

## Troubleshooting

### Email Not Sending

1. **Check SMTP credentials**: Verify login email and SMTP key
2. **Verify sender email**: Ensure your FROM email is verified in Brevo
3. **Check logs**: Look at `storage/logs/laravel.log` for error messages
4. **API limits**: Free Brevo accounts have daily sending limits (300 emails/day)
5. **Configuration cache**: Run `php artisan config:clear`

### Common Errors

- **Authentication failed**: Wrong SMTP key or login email
- **Sender not verified**: FROM email not verified in Brevo dashboard
- **Daily limit exceeded**: Upgrade your Brevo plan or wait 24 hours
- **Connection timeout**: Check port (587) and firewall settings

### Testing Locally

For local development, you can temporarily use `MAIL_MAILER=log` to log emails to `storage/logs/laravel.log` instead of sending them.

## Brevo Free Plan Limits

- 300 emails per day
- Unlimited contacts
- Email templates
- SMTP relay
- Basic reporting

For higher limits, consider upgrading to a paid plan.

## Security Best Practices

1. Never commit your `.env` file to version control
2. Use strong, unique SMTP keys
3. Rotate SMTP keys periodically
4. Monitor email sending activity in Brevo dashboard
5. Enable two-factor authentication on your Brevo account

## Support

- Brevo Documentation: https://developers.brevo.com/
- Brevo Support: https://help.brevo.com/
- Laravel Mail Documentation: https://laravel.com/docs/mail

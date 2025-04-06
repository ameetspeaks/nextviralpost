# NextViralPost - AI-Powered Content Generation Platform

NextViralPost is a sophisticated content generation platform built with Laravel, designed to help users create engaging and viral content for social media platforms. The platform leverages AI technology to assist in content creation and optimization.

## Features

### User Management
- **Authentication System**
  - Secure registration and login
  - Email verification
  - Password reset functionality
  - Role-based access control (Admin, Super Admin, User roles)
  - Profile management with customizable settings

### Content Generation
- **AI-Powered Content Creation**
  - Generate viral content ideas
  - Create engaging social media posts
  - Customizable content templates
  - Industry-specific content suggestions
  - Content optimization recommendations

### Social Media Integration
- **Platform Support**
  - LinkedIn integration
  - Copy and share functionality
  - Social media analytics
  - Post scheduling capabilities

### User Experience
- **Intuitive Interface**
  - Modern, responsive design
  - User-friendly dashboard
  - Customizable user templates
  - Real-time content preview
  - Interactive content editing

### Security Features
- **Advanced Security**
  - Role-based permissions
  - Secure authentication
  - Data encryption
  - Session management
  - Protected API endpoints

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/nextviralpost.git
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Set up database:
```bash
php artisan migrate
php artisan db:seed
```

5. Configure Mailgun for email verification:
- Add your Mailgun credentials to `.env` file
- Set up domain verification

## Configuration

### Environment Variables
- `MAILGUN_DOMAIN`: Your Mailgun domain
- `MAILGUN_SECRET`: Your Mailgun API key
- `MAILGUN_ENDPOINT`: Mailgun API endpoint
- `MAIL_FROM_ADDRESS`: Sender email address
- `MAIL_FROM_NAME`: Sender name

### Database
- MySQL/MariaDB
- Redis (for caching and queues)

## Usage

1. Register a new account
2. Complete email verification
3. Access the dashboard
4. Generate content using AI tools
5. Customize and share content

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support, email support@nextviralpost.com or create an issue in the repository.

## Acknowledgments

- Laravel Framework
- OpenAI API
- Mailgun
- All contributors and maintainers

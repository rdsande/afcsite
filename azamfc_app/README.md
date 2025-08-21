# Azam FC Mobile App

A modern Flutter mobile application for Azam FC fans, featuring a beautiful UI with smooth animations and full localization support (Swahili and English).

## Features

### 🎯 Core Features

- **Splash Screen**: Beautiful animated logo with smooth transitions
- **Onboarding**: App feature showcase with language selection
- **Authentication**: Fan registration and login system
- **Home Screen**: Match results, upcoming fixtures, and personalized greetings
- **News**: Latest club news and updates
- **Fixtures**: Match schedule and results
- **Shop**: Official merchandise store
- **Account**: Fan profile and settings
- **Players**: Team squad information

### 🌍 Localization

- **Swahili (Primary)**: Full Swahili language support
- **English**: Complete English localization
- **Dynamic Switching**: Change language on-the-fly

### 🎨 Design Features

- **Modern UI**: Material 3 design with custom Azam FC branding
- **Smooth Animations**: Flutter Animate for delightful user experience
- **Responsive Design**: Optimized for all screen sizes
- **Dark/Light Themes**: Theme switching support
- **Custom Components**: Beautiful, reusable UI components

### 🔧 Technical Features

- **State Management**: Riverpod for efficient state management
- **Local Storage**: Hive for fast local data persistence
- **HTTP Client**: Dio for API communication
- **Image Caching**: Efficient image loading and caching
- **Code Generation**: JSON serialization and API client generation

## Screenshots

The app includes screens that match your provided designs:

- Splash screen with Azam FC logo and Bakresa Group branding
- Onboarding with app features and language selection
- Registration form matching your web form exactly
- Home screen with match cards and upcoming fixtures
- Modern bottom navigation with custom app bar

## Project Structure

```
lib/
├── constants/          # App constants and configuration
├── models/            # Data models matching Laravel backend
├── providers/         # State management providers
├── screens/           # App screens and pages
├── services/          # API and business logic services
├── utils/             # Utility functions and helpers
├── widgets/           # Reusable UI components
└── main.dart          # App entry point
```

## Setup Instructions

### Prerequisites

- Flutter SDK 3.10.0 or higher
- Dart SDK 3.0.0 or higher
- Android Studio / VS Code
- Git

### Installation

1. **Clone the repository**

   ```bash
   git clone <repository-url>
   cd azamfc_app
   ```

2. **Install dependencies**

   ```bash
   flutter pub get
   ```

3. **Run the app**
   ```bash
   flutter run
   ```

### Configuration

The app is configured to work with your existing Laravel backend. Update the following files as needed:

- **API Endpoints**: Update `lib/services/api_service.dart` with your backend URLs
- **App Configuration**: Modify `lib/constants/app_config.dart` for environment-specific settings
- **Assets**: Add your images and icons to the `assets/` directory

## Development

### Code Generation

The app uses code generation for JSON serialization and API clients:

```bash
# Generate JSON serialization code
flutter packages pub run build_runner build

# Watch for changes and regenerate automatically
flutter packages pub run build_runner watch
```

### Adding New Features

1. **Create Models**: Add new data models in `lib/models/`
2. **Update Providers**: Extend state management in `lib/providers/`
3. **Add Screens**: Create new screens in `lib/screens/`
4. **Create Widgets**: Build reusable components in `lib/widgets/`

### Localization

To add new text strings:

1. Update the language provider
2. Add translations to both Swahili and English
3. Use the language provider in your widgets

## Integration with Laravel Backend

The app is designed to work seamlessly with your existing Laravel system:

### Shared Features

- **User Authentication**: Same login/registration system
- **Data Models**: Matching database structure
- **API Endpoints**: RESTful API integration
- **Content Management**: News, fixtures, and player data

### Admin Dashboard Extensions

You can extend your existing admin dashboard to manage:

- App logo and splash screen images
- App-specific content and settings
- Push notifications
- Analytics and user insights

## Building for Production

### Android

```bash
flutter build apk --release
flutter build appbundle --release
```

### iOS

```bash
flutter build ios --release
```

### Web

```bash
flutter build web --release
```

## Dependencies

### Core Dependencies

- **flutter_riverpod**: State management
- **dio**: HTTP client
- **hive**: Local storage
- **flutter_animate**: Animations
- **google_fonts**: Typography
- **cached_network_image**: Image handling

### Development Dependencies

- **build_runner**: Code generation
- **json_serializable**: JSON serialization
- **retrofit_generator**: API client generation

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions:

- Create an issue in the repository
- Contact the development team
- Check the documentation

## Roadmap

### Phase 1 (Current)

- ✅ Basic app structure
- ✅ Authentication system
- ✅ Core screens
- ✅ Localization

### Phase 2 (Next)

- 🔄 API integration
- 🔄 Push notifications
- 🔄 Offline support
- 🔄 Advanced animations

### Phase 3 (Future)

- 📱 Live match updates
- 📱 Social features
- 📱 Advanced analytics
- 📱 AR/VR features

---

**Built with ❤️ for Azam FC fans**

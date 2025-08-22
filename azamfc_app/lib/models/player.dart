import '../utils/image_utils.dart';

class Player {
  final int id;
  final String name;
  final String position;
  final int jerseyNumber;
  final String? image;
  final String nationality;
  final DateTime dateOfBirth;
  final String? team;
  final String? height;
  final String? weight;
  final String? bio;
  final String? videoUrl;
  final bool isActive;

  Player({
    required this.id,
    required this.name,
    required this.position,
    required this.jerseyNumber,
    this.image,
    required this.nationality,
    required this.dateOfBirth,
    this.team,
    this.height,
    this.weight,
    this.bio,
    this.videoUrl,
    this.isActive = true,
  });

  factory Player.fromJson(Map<String, dynamic> json) {
    return Player(
      id: json['id'],
      name: json['name'] ?? '',
      position: json['position'] ?? '',
      jerseyNumber: json['jersey_number'] ?? json['jerseyNumber'] ?? 0,
      image: ImageUtils.getFullImageUrl(json['image'] ?? json['profile_image']),
      nationality: json['nationality'] ?? 'Tanzania',
      dateOfBirth: DateTime.parse(json['date_of_birth'] ?? json['dateOfBirth'] ?? DateTime.now().toIso8601String()),
      team: json['team'] ?? json['team_category'],
      height: json['height'],
      weight: json['weight'],
      bio: json['bio'] ?? json['biography'],
      videoUrl: json['video_url'] ?? json['videoUrl'],
      isActive: json['is_active'] ?? json['isActive'] ?? true,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'position': position,
      'jerseyNumber': jerseyNumber,
      'image': image,
      'nationality': nationality,
      'dateOfBirth': dateOfBirth.toIso8601String(),
      'team': team,
      'height': height,
      'weight': weight,
      'bio': bio,
      'videoUrl': videoUrl,
      'isActive': isActive,
    };
  }

  int get age {
    final now = DateTime.now();
    int age = now.year - dateOfBirth.year;
    if (now.month < dateOfBirth.month || 
        (now.month == dateOfBirth.month && now.day < dateOfBirth.day)) {
      age--;
    }
    return age;
  }

  String get positionAbbreviation {
    switch (position.toLowerCase()) {
      case 'goalkeeper':
        return 'GK';
      case 'defender':
        return 'DEF';
      case 'midfielder':
        return 'MID';
      case 'forward':
        return 'FWD';
      default:
        return position.substring(0, 3).toUpperCase();
    }
  }
}

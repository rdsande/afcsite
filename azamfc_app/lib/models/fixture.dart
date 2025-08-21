import '../utils/image_utils.dart';

class Fixture {
  final int id;
  final String homeTeam;
  final String awayTeam;
  final DateTime matchDate;
  final String tournament;
  final String status;
  final String venue;
  final int? homeScore;
  final int? awayScore;
  final String? homeTeamLogo;
  final String? awayTeamLogo;

  Fixture({
    required this.id,
    required this.homeTeam,
    required this.awayTeam,
    required this.matchDate,
    required this.tournament,
    required this.status,
    required this.venue,
    this.homeScore,
    this.awayScore,
    this.homeTeamLogo,
    this.awayTeamLogo,
  });

  factory Fixture.fromJson(Map<String, dynamic> json) {
    final homeTeamLogoUrl = ImageUtils.getFullImageUrl(json['home_team']?['logo'] ?? json['home_team_logo'] ?? json['homeTeamLogo']);
    final awayTeamLogoUrl = ImageUtils.getFullImageUrl(json['away_team']?['logo'] ?? json['away_team_logo'] ?? json['awayTeamLogo']);
    
    print('Fixture.fromJson: Original home team logo: ${json['home_team']?['logo'] ?? json['home_team_logo'] ?? json['homeTeamLogo']}');
    print('Fixture.fromJson: Generated home team logo URL: $homeTeamLogoUrl');
    print('Fixture.fromJson: Original away team logo: ${json['away_team']?['logo'] ?? json['away_team_logo'] ?? json['awayTeamLogo']}');
    print('Fixture.fromJson: Generated away team logo URL: $awayTeamLogoUrl');
    
    return Fixture(
      id: json['id'] ?? 0,
      homeTeam: json['home_team']?['name'] ?? json['home_team'] ?? json['homeTeam'] ?? '',
      awayTeam: json['away_team']?['name'] ?? json['away_team'] ?? json['awayTeam'] ?? '',
      matchDate: DateTime.parse(json['match_date'] ?? json['matchDate'] ?? DateTime.now().toIso8601String()),
      tournament: json['tournament']?['name'] ?? json['tournament'] ?? '',
      status: json['status'] ?? 'scheduled',
      venue: json['stadium'] ?? json['venue'] ?? '',
      homeScore: json['home_score'] ?? json['homeScore'],
      awayScore: json['away_score'] ?? json['awayScore'],
      homeTeamLogo: homeTeamLogoUrl,
      awayTeamLogo: awayTeamLogoUrl,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'homeTeam': homeTeam,
      'awayTeam': awayTeam,
      'matchDate': matchDate.toIso8601String(),
      'tournament': tournament,
      'status': status,
      'venue': venue,
      'homeScore': homeScore,
      'awayScore': awayScore,
      'homeTeamLogo': homeTeamLogo,
      'awayTeamLogo': awayTeamLogo,
    };
  }

  bool get isCompleted => status == 'completed';
  bool get isScheduled => status == 'scheduled';
  bool get isLive => status == 'live';
  
  String get formattedDate {
    return '${matchDate.day}/${matchDate.month}/${matchDate.year}';
  }
  
  String get formattedTime {
    return '${matchDate.hour.toString().padLeft(2, '0')}:${matchDate.minute.toString().padLeft(2, '0')}';
  }
  
  String get matchStatus {
    if (isCompleted) return 'FT';
    if (isLive) return 'LIVE';
    return 'VS';
  }
}

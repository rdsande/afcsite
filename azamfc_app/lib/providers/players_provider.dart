import 'package:flutter_riverpod/flutter_riverpod.dart';
import '../models/player.dart';
import '../services/api_service.dart';
import 'news_provider.dart';

// Players state class
class PlayersState {
  final Map<String, List<Player>> seniorPlayers;
  final List<Player> allPlayers;
  final bool isLoading;
  final String? error;

  const PlayersState({
    this.seniorPlayers = const {},
    this.allPlayers = const [],
    this.isLoading = false,
    this.error,
  });

  PlayersState copyWith({
    Map<String, List<Player>>? seniorPlayers,
    List<Player>? allPlayers,
    bool? isLoading,
    String? error,
  }) {
    return PlayersState(
      seniorPlayers: seniorPlayers ?? this.seniorPlayers,
      allPlayers: allPlayers ?? this.allPlayers,
      isLoading: isLoading ?? this.isLoading,
      error: error ?? this.error,
    );
  }
}

// Players notifier
class PlayersNotifier extends StateNotifier<PlayersState> {
  final ApiService _apiService;

  PlayersNotifier(this._apiService) : super(const PlayersState());

  Future<void> fetchSeniorPlayers() async {
    state = state.copyWith(isLoading: true, error: null);
    try {
      final players = await _apiService.getSeniorPlayers();
      state = state.copyWith(
        seniorPlayers: players,
        isLoading: false,
      );
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: e.toString(),
      );
    }
  }

  Future<void> fetchAllPlayers({int page = 1, String? position, String? team}) async {
    state = state.copyWith(isLoading: true, error: null);
    try {
      final players = await _apiService.getAllPlayers(
        page: page,
        position: position,
        team: team,
      );
      state = state.copyWith(
        allPlayers: players,
        isLoading: false,
      );
    } catch (e) {
      state = state.copyWith(
        isLoading: false,
        error: e.toString(),
      );
    }
  }

  Future<Player?> getPlayerDetail(int playerId) async {
    try {
      return await _apiService.getPlayerDetail(playerId);
    } catch (e) {
      print('Error fetching player detail: $e');
      return null;
    }
  }
}

// Provider instances
final playersProvider = StateNotifierProvider<PlayersNotifier, PlayersState>((ref) {
  final apiService = ref.watch(apiServiceProvider);
  return PlayersNotifier(apiService);
});

// Convenience providers
final seniorPlayersProvider = Provider<Map<String, List<Player>>>((ref) {
  return ref.watch(playersProvider).seniorPlayers;
});

final allPlayersProvider = Provider<List<Player>>((ref) {
  return ref.watch(playersProvider).allPlayers;
});

final playersLoadingProvider = Provider<bool>((ref) {
  return ref.watch(playersProvider).isLoading;
});

final playersErrorProvider = Provider<String?>((ref) {
  return ref.watch(playersProvider).error;
});
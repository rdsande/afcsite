<div class="uk-section">
    <div class="uk-container">
        <div class="uk-padding psmall topsort">
            <span class="primarysort">SORT BY SEASON</span>
            <div class="quicknavposts">
                <nav class="uk-navbar-container">
                    <div class="uk-container">
                        <div uk-navbar>
                            <div class="uk-navbar-left">
                                <ul class="uk-navbar-nav plyrposition">
                                    <li><a href="#pl" uk-scroll>TANZANIA PREMIER LEAGUE</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <h4 class="uk-heading-line uk-text-right">
                <div class="uk-margin">
                    <div class="uk-form-controls">
                        <select class="uk-select" id="season-select">
                            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                            <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                            <option value="{{ date('Y') - 2 }}">{{ date('Y') - 2 }}</option>
                            <option value="{{ date('Y') - 3 }}">{{ date('Y') - 3 }}</option>
                        </select>
                    </div>
                </div>
            </h4>
        </div>
    </div>
    
    <!-- Tanzania Premier League Standings -->
    <div class="uk-container uk-container-medium games-tables" id="pl">
        <div class="uk-card uk-card-default uk-card-body">
            <div id="loading-spinner" class="uk-text-center uk-margin-large">
                <div uk-spinner="ratio: 2"></div>
                <p>Loading league standings...</p>
            </div>
            
            <div id="standings-table" style="display: none;">
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-striped uk-table-hover uk-table-small">
                        <thead>
                            <tr class="uk-background-primary uk-light">
                                <th class="uk-text-center">#</th>
                                <th>Team</th>
                                <th class="uk-text-center">MP</th>
                                <th class="uk-text-center">W</th>
                                <th class="uk-text-center">D</th>
                                <th class="uk-text-center">L</th>
                                <th class="uk-text-center">GF</th>
                                <th class="uk-text-center">GA</th>
                                <th class="uk-text-center">GD</th>
                                <th class="uk-text-center">PTS</th>
                                <th class="uk-text-center">Form</th>
                            </tr>
                        </thead>
                        <tbody id="standings-body">
                            <!-- Dynamic content will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div id="no-data" style="display: none;" class="uk-text-center uk-margin-large">
                <p class="uk-text-muted">No standings data available for the selected season.</p>
            </div>
        </div>
    </div>
</div>

<script>
// League standings functionality
document.addEventListener('DOMContentLoaded', function() {
    const seasonSelect = document.getElementById('season-select');
    const loadingSpinner = document.getElementById('loading-spinner');
    const standingsTable = document.getElementById('standings-table');
    const standingsBody = document.getElementById('standings-body');
    const noDataDiv = document.getElementById('no-data');
    
    // Load initial standings
    loadStandings();
    
    // Handle season change
    seasonSelect.addEventListener('change', function() {
        loadStandings();
    });
    
    function loadStandings() {
        const season = seasonSelect.value;
        
        // Show loading spinner
        loadingSpinner.style.display = 'block';
        standingsTable.style.display = 'none';
        noDataDiv.style.display = 'none';
        
        // Fetch standings data
        fetch(`/api/league/standings?league=Tanzania Premier League&season=${season}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    displayStandings(data.data);
                } else {
                    showNoData();
                }
            })
            .catch(error => {
                console.error('Error loading standings:', error);
                showNoData();
            });
    }
    
    function displayStandings(standings) {
        standingsBody.innerHTML = '';
        
        standings.forEach(team => {
            const row = document.createElement('tr');
            
            // Add position-based styling
            if (team.position <= 3) {
                row.classList.add('uk-background-muted');
            }
            
            row.innerHTML = `
                <td class="uk-text-center uk-text-bold">${team.position}</td>
                <td>
                    <div class="uk-flex uk-flex-middle">
                        ${team.team && team.team.logo ? 
                            `<img src="/storage/${team.team.logo}" alt="${team.team ? team.team.name : 'Team'}" class="uk-border-circle" width="24" height="24" style="margin-right: 8px;">` : 
                            '<div class="uk-width-small uk-height-small uk-background-muted uk-border-circle" style="margin-right: 8px;"></div>'
                        }
                        <span class="uk-text-bold">${team.team ? team.team.name : 'Unknown Team'}</span>
                    </div>
                </td>
                <td class="uk-text-center">${team.matches_played}</td>
                <td class="uk-text-center uk-text-success">${team.wins}</td>
                <td class="uk-text-center uk-text-warning">${team.draws}</td>
                <td class="uk-text-center uk-text-danger">${team.losses}</td>
                <td class="uk-text-center">${team.goals_for}</td>
                <td class="uk-text-center">${team.goals_against}</td>
                <td class="uk-text-center ${team.goal_difference >= 0 ? 'uk-text-success' : 'uk-text-danger'}">
                    ${team.goal_difference >= 0 ? '+' : ''}${team.goal_difference}
                </td>
                <td class="uk-text-center uk-text-bold uk-text-primary">${team.points}</td>
                <td class="uk-text-center">
                    <span class="uk-text-small">${team.formatted_form || '-'}</span>
                </td>
            `;
            
            standingsBody.appendChild(row);
        });
        
        // Hide loading and show table
        loadingSpinner.style.display = 'none';
        standingsTable.style.display = 'block';
    }
    
    function showNoData() {
        loadingSpinner.style.display = 'none';
        standingsTable.style.display = 'none';
        noDataDiv.style.display = 'block';
    }
});
</script>
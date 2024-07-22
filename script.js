let clients = [];
let currentGroup = [];
let displayedRows = 10; // Number of rows initially displayed

function loadGroup(groupNumber) {
    const groupFile = `group${groupNumber}.csv`;
    fetch(groupFile)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            const rows = data.split('\n').slice(1);
            clients = rows.map(row => {
                const cols = row.split(',');
                return {
                    id: cols[0],
                    score: parseFloat(cols[1]),
                    emails_sent: parseInt(cols[2]),
                    open_rate: parseFloat(cols[3]),
                    unsubscribe_rate: parseFloat(cols[4]),
                    bounce_rate: parseFloat(cols[5]),
                    complaint_rate: parseFloat(cols[6])
                };
            });
            currentGroup = clients;
            displayedRows = 10; // Reset displayed rows
            displayClients(clients, displayedRows);
        })
        .catch(error => {
            console.error('Error loading clients:', error);
            alert('Failed to load clients data. Please check the console for more details.');
        });
}

function displayClients(clients, limit) {
    const tbody = document.querySelector('#clientTable tbody');
    const fragment = document.createDocumentFragment();
    clients.slice(0, limit).forEach(client => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${client.id}</td>
            <td>${client.score}</td>
            <td>${client.emails_sent}</td>
            <td>${client.open_rate}</td>
            <td>${client.unsubscribe_rate}</td>
            <td>${client.bounce_rate}</td>
            <td>${client.complaint_rate}</td>
        `;
        fragment.appendChild(row);
    });
    tbody.innerHTML = '';
    tbody.appendChild(fragment);

    // Hide or show the "Load More" button
    document.getElementById('loadMore').style.display = clients.length > limit ? 'block' : 'none';
}

function searchClient() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const filteredClients = currentGroup.filter(client => client.id.toLowerCase().includes(input));
    displayClients(filteredClients, displayedRows);
}

function sortTableAsc() {
    currentGroup.sort((a, b) => a.score - b.score);
    displayClients(currentGroup, displayedRows);
}

function sortTableDesc() {
    currentGroup.sort((a, b) => b.score - a.score);
    displayClients(currentGroup, displayedRows);
}


function loadMoreRows() {
    displayedRows += 10; // Increment the number of rows to display by 10
    displayClients(currentGroup, displayedRows);
}
function formatProfile(profile) {
    return `
    <p>Average Score: ${profile.average_score.toFixed(4)}</p>
    <p>Average Emails Sent: ${profile.average_emails_sent.toFixed(4)}</p>
    <p>Average Open Rate: ${profile.average_open_rate.toFixed(4)}%</p>
    <p>Average Unsubscribe Rate: ${profile.average_unsubscribe_rate.toFixed(4)}%</p>
    <p>Average Bounce Rate: ${profile.average_bounce_rate.toFixed(4)}%</p>
    <p>Average Complaint Rate: ${profile.average_complaint_rate.toFixed(4)}%</p>`;
}

function loadTypicalProfiles() {
    fetch('typical_profiles.json')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('group1Profile').innerHTML = `<h3>Group 1</h3>${formatProfile(data.group1)}`;
            document.getElementById('group2Profile').innerHTML = `<h3>Group 2</h3>${formatProfile(data.group2)}`;
            document.getElementById('group3Profile').innerHTML = `<h3>Group 3</h3>${formatProfile(data.group3)}`;
        })
        .catch(error => {
            console.error('Error loading typical profiles:', error);
            alert('Failed to load typical profiles. Please check the console for more details.');
        });
}

function filterGroup(groupNumber) {
    loadGroup(groupNumber);
}

// Load group 1 data by default
loadGroup(1);

// Load typical profiles
loadTypicalProfiles();


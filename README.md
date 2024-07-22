# Brevo
Test technique Client Analysis


## Overview

This project aims to analyze client data provided by Brevo, assign performance scores to each client, and categorize them into three groups based on the number of emails sent. The analysis is performed using a backend PHP script, and the results are displayed on a frontend interface with filtering and sorting capabilities.

## Data

The provided CSV file (`brevo_casestudy_data.csv`) contains approximately 40,000 rows of data. Each row includes the following columns:

1. `ID`: The account ID at Brevo
2. `Emails Sent`: The number of emails sent in the last 7 days
3. `Open Rate`: The average open rate
4. `Unsubscription Rate`: The average unsubscription rate
5. `Bounce Rate`: The average bounce rate
6. `Complaint Rate`: The average complaint rate

## Requirements

### Backend (PHP)

1. **Score Calculation**:
   - Assign a performance score to each client based on the provided statistics.
   - Design a formula that reflects the performance accurately.

2. **Categorization**:
   - Categorize clients into three groups based on the number of emails sent (`Emails Sent` column).
   - The first group should contain the top 1/3 of clients by the total number of emails sent.
   - The second group should contain the middle 1/3 of clients.
   - The third group should contain the bottom 1/3 of clients.

### Frontend

1. **User Interface**:
   - Create a simple UI to display the results.
   - Implement filtering and sorting capabilities (filter by group, search by client ID, sort by score).

2. **Data Display**:
   - Show the data for each client along with the calculated score.
   - Display a "typical profile" for each of the three groups in terms of the provided statistics.

## Backend Implementation

The backend is implemented in PHP with scripts to calculate the performance scores and categorize the clients.

### Score Calculation Formula

The formula used to calculate the score for each client considers the gravity of each attribute using specific weights:

- `Open Rate`: Weight = 2.0
- `Unsubscription Rate`: Weight = -3.0
- `Bounce Rate`: Weight = -2.0
- `Complaint Rate`: Weight = -4.0

These weights ensure that the calculated score accurately reflects the client's overall performance.

### Client Categorization

After calculating the scores, clients are categorized into three groups based on the number of emails sent. The steps involved in this process are:

1. **Sorting by Emails Sent**:
   - Clients are sorted in descending order based on the number of emails sent.

2. **Total Emails Sent Calculation**:
   - The total number of emails sent by all clients is calculated.

3. **Group Size Determination**:
   - The total number of emails sent is divided by three to determine the size of each group.

4. **Categorization**:
   - Clients are categorized into three groups such that each group contains approximately one-third of the total number of emails sent.
     - The first group contains the top 1/3 of clients by the total number of emails sent.
     - The second group contains the middle 1/3 of clients.
     - The third group contains the bottom 1/3 of clients.

The categorized data is then saved into three separate CSV files: `group1.csv`, `group2.csv`, and `group3.csv`.

### Typical Profiles Calculation

Using the categorized data, typical profiles for each group are calculated and saved to a JSON file. This involves computing the average values for each statistical measure within each group.

## Frontend Implementation

The frontend interface displays the categorized client data with capabilities to filter and sort the information. The UI is implemented using HTML, CSS, and JavaScript.

### Interface Features

1. **Navigation Buttons**:
   - Buttons to show data for each group (Group 1, Group 2, Group 3).
   - A button to sort the data by score.

2. **Search Functionality**:
   - A search bar to filter clients by their ID.

3. **Data Table**:
   - A table displaying the client data including the calculated score, emails sent, open rate, unsubscription rate, bounce rate, and complaint rate.
   - Initially, only 10 rows are displayed with a "Load More" button to display additional rows.

4. **Typical Profiles**:
   - Typical profiles for each group are displayed at the bottom of the interface.
   - These profiles show the average values for each statistical measure within the group.

### Development Environment

This project was developed using XAMPP for Apache and MySQL. XAMPP provides an easy-to-use and pre-configured environment to run PHP scripts.

---


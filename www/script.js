// Initialize chart variables
let chart;
const labels = ['CR Tp1', 'CR Tp2', 'Ctrl SQL', 'Ctrl C++', 'Ctrl PHP', 'Ctrl Javascript'];
const data = [12, 19, 15, 10, 8, 14.5];

// Execute the function to display the graph
afficherGraphique();

// Function to display the graph
function afficherGraphique() {
    const ctx = document.getElementById('myChart').getContext('2d');

    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Relevé de notes de Jack Ouille',
                data: data,
                borderWidth: 1,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
            }]
        },
        options: {
            scales: {
                y: {
                    max: 20,
                    min: 0,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

// Handle form submission
document.getElementById('gradeForm').onsubmit = function(e) {
    e.preventDefault(); // Prevent the form from submitting the traditional way

    const nom = document.getElementById('nom').value;
    const note = parseFloat(document.getElementById('pages').value);

    // Add a new label and note to the chart
    if (nom && !isNaN(note)) {
        labels.push(nom); // Add the control name to the labels array
        data.push(note); // Add the note to the data array

        // Update the chart
        chart.data.labels = labels;
        chart.data.datasets[0].data = data;
        chart.update(); // Refresh the chart to reflect the new data
    }
    
    // Clear the form inputs for the next entry
    document.getElementById('gradeForm').reset();
};
// Import Chart.js
import {
    Chart, BarController, BarElement, LinearScale, TimeScale, Tooltip, Legend,
  } from 'chart.js';
import { isEmpty } from 'lodash';
  
  // Import utilities
  import { tailwindConfig, formatValue } from '../utils';
  
  Chart.register(BarController, BarElement, LinearScale, TimeScale, Tooltip, Legend);
  
  // A chart built with Chart.js 3
  // https://www.chartjs.org/
  let chart = null;
  const arDays = () => {
    const ctx = document.getElementById('ar-days-chart');
    if (!ctx) return;
    if (chart != null) {
        chart.destroy();
    }
    const year = $("#ar-search").val();
  
    fetch(`/dashboard/getar?year=${year}`)
      .then(a => {
        return a.json();
      })
      .then(result => {
        let dataset1 = result.data1;
        let label1 = result.labels1;
        let dataset2 = result.data2;
        let label2 = result.labels2;

        if (isEmpty(dataset1) || isEmpty(label1) || isEmpty(dataset2) || isEmpty(label2)) {
            dataset1 = [0];
            label1 = ['-'];
            dataset2 = [0];
            label2 = ['-'];
        }
        
        chart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: label1,
            datasets: [
              // Light blue bars
              {
                label: `Total Unpaid Invoice in ${year == "" ? new Date().getFullYear() : year}`,
                data: dataset1,
                backgroundColor: tailwindConfig().theme.colors.blue[400],
                hoverBackgroundColor: tailwindConfig().theme.colors.blue[500],
                barPercentage: 0.66,
                categoryPercentage: 0.66,
              },
              {
                label: `Total Paid Invoice in ${year == "" ? new Date().getFullYear() : year}`,
                data: dataset2,
                backgroundColor: tailwindConfig().theme.colors.emerald[400],
                hoverBackgroundColor: tailwindConfig().theme.colors.emerald[500],
                barPercentage: 0.66,
                categoryPercentage: 0.66,
              },
            ],
          },
          options: {
            layout: {
              padding: {
                top: 12,
                bottom: 16,
                left: 20,
                right: 20,
              },
            },
            scales: {
              y: {
                grid: {
                  drawBorder: false,
                },
                ticks: {
                  maxTicksLimit: 5,
                  callback: (value) => formatValue(value),
                },
              },
              x: {
                type: 'time',
                time: {
                  parser: 'MMM',
                  unit: 'month',
                  displayFormats: {
                    month: 'MMM',
                  },
                },
                grid: {
                  display: false,
                  drawBorder: false,
                },
              },
            },
            plugins: {
              legend: {
                display: false,
              },
              htmlLegend: {
                // ID of the container to put the legend in
                containerID: 'ar-days-legend',
              },
              tooltip: {
                callbacks: {
                  title: () => false, // Disable tooltip title
                  label: (context) => formatValue(context.parsed.y),
                },
              },
            },
            interaction: {
              intersect: false,
              mode: 'nearest',
            },
            animation: {
              duration: 200,
            },
            maintainAspectRatio: false,
          },
          plugins: [{
            id: 'htmlLegend',
            afterUpdate(c, args, options) {
              const legendContainer = document.getElementById(options.containerID);
              const ul = legendContainer.querySelector('ul');
              if (!ul) return;
              // Remove old legend items
              while (ul.firstChild) {
                ul.firstChild.remove();
              }
              // Reuse the built-in legendItems generator
              const items = c.options.plugins.legend.labels.generateLabels(c);
              items.forEach((item) => {
                const li = document.createElement('li');
                li.style.marginRight = tailwindConfig().theme.margin[4];
                // Button element
                const button = document.createElement('button');
                button.style.display = 'inline-flex';
                button.style.alignItems = 'center';
                button.style.opacity = item.hidden ? '.3' : '';
                button.onclick = () => {
                  c.setDatasetVisibility(item.datasetIndex, !c.isDatasetVisible(item.datasetIndex));
                  c.update();
                };
                // Color box
                const box = document.createElement('span');
                box.style.display = 'block';
                box.style.width = tailwindConfig().theme.width[3];
                box.style.height = tailwindConfig().theme.height[3];
                box.style.borderRadius = tailwindConfig().theme.borderRadius.full;
                box.style.marginRight = tailwindConfig().theme.margin[2];
                box.style.borderWidth = '3px';
                box.style.borderColor = item.fillStyle;
                box.style.pointerEvents = 'none';
                // Label
                const labelContainer = document.createElement('span');
                labelContainer.style.display = 'flex';
                labelContainer.style.alignItems = 'center';
                const value = document.createElement('span');
                value.style.color = tailwindConfig().theme.colors.slate[800];
                value.style.fontSize = tailwindConfig().theme.fontSize['3xl'][0];
                value.style.lineHeight = tailwindConfig().theme.fontSize['3xl'][1].lineHeight;
                value.style.fontWeight = tailwindConfig().theme.fontWeight.bold;
                value.style.marginRight = tailwindConfig().theme.margin[2];
                value.style.pointerEvents = 'none';
                const label = document.createElement('span');
                label.style.color = tailwindConfig().theme.colors.slate[500];
                label.style.fontSize = tailwindConfig().theme.fontSize.sm[0];
                label.style.lineHeight = tailwindConfig().theme.fontSize.sm[1].lineHeight;
                const theValue = c.data.datasets[item.datasetIndex].data.reduce((a, b) => a + b, 0);
                const formattedValue = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 3, notation: 'compact' }).format(theValue);
                const valueText = document.createTextNode(formattedValue);
                const labelText = document.createTextNode(item.text);
                value.appendChild(valueText);
                label.appendChild(labelText);
                li.appendChild(button);
                button.appendChild(box);
                button.appendChild(labelContainer);
                labelContainer.appendChild(value);
                labelContainer.appendChild(label);
                ul.appendChild(li);
              });
            },
          }],
        });
      });
  };
  
  export default arDays;
  
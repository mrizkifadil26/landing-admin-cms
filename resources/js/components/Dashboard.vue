<template>
  <div class="animated fadeIn">
    <b-row>

      <b-col sm="6" lg="3">
        <b-card class="text-white bg-success">
          <div class="h3 text-muted text-right mb-4">
            <i class="far fa-newspaper"></i>
          </div>
          <h1 class="h1 mb-0">{{ count.post }}</h1>
          <small class="text-muted text-uppercase font-weight-bold">Post(s)</small>  
        </b-card>
      </b-col>

      <b-col sm="6" lg="3">
        <b-card class="text-white bg-primary">
          <div class="h3 text-muted text-right mb-4">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <h1 class="h1 mb-0">{{ count.location }}</h1>
          <small class="text-muted text-uppercase font-weight-bold">Location(s)</small>  
        </b-card>
      </b-col>

      <b-col sm="6" lg="3">
        <b-card class="text-white bg-danger">
          <div class="h3 text-muted text-right mb-4">
            <i class="fas fa-list"></i>
          </div>
          <h1 class="h1 mb-0">{{ count.complaint }}</h1>
          <small class="text-muted text-uppercase font-weight-bold">Complaint(s)</small>  
        </b-card>
      </b-col>

      <b-col sm="6" lg="3">
        <b-card class="text-white bg-warning">
          <div class="h3 text-muted text-right mb-4">
            <i class="far fa-user"></i>
          </div>
          <h1 class="h1 mb-0">{{ count.user }}</h1>
          <small class="text-muted text-uppercase font-weight-bold">User(s)</small>  
        </b-card>
      </b-col>

    </b-row>

    <b-card>
      <b-row>
        <b-col sm="5">
          <h4 id="traffic" class="card-title mb-0">Complaint</h4>
          <div class="small text-muted">February 2019</div>
        </b-col>
        <b-col sm="7" class="d-none d-md-block">
          <b-button type="button" variant="primary" class="float-right"><i class="fas fa-download"></i></b-button>
          <b-button-toolbar class="float-right" aria-label="Toolbar with buttons group">
            <b-form-radio-group class="mr-3" id="radiosBtn" buttons button-variant="outline-secondary" v-model="selected" name="radiosBtn">
              <b-form-radio class="mx-0" value="Day">Day</b-form-radio>
              <b-form-radio class="mx-0" value="Month">Month</b-form-radio>
              <b-form-radio class="mx-0" value="Year">Year</b-form-radio>
            </b-form-radio-group>
          </b-button-toolbar>
        </b-col>
      </b-row>
      <main-chart-example chartId="main-chart-01" class="chart-wrapper" style="height:300px;margin-top:40px;" height="300"></main-chart-example>
    </b-card>

  </div>
</template>

<script>

import { Line } from 'vue-chartjs'
import { getStyle, hexToRgba } from '@coreui/coreui/dist/js/coreui-utilities'
import { CustomTooltips } from '@coreui/coreui-plugin-chartjs-custom-tooltips'
import axios from 'axios'

export default {
  name: 'Dashboard',
  extends: Line,
  props: ['height'],
  data() {
    return {
      data: '',
      count: {
        post: 15,
        location: 30,
        complaint: 40,
        user: 10,
      }
    }
  },
  mounted () {

    const brandSuccess = getStyle('--success') || '#4dbd74'
    const brandInfo = getStyle('--info') || '#20a8d8'
    const brandDanger = getStyle('--danger') || '#f86c6b'

    let elements = 27
    const data1 = []
    const data2 = []
    const data3 = []

    for (let i = 0; i <= elements; i++) {
      data1.push(random(50, 200))
      data2.push(random(80, 100))
      data3.push(65)
    }
    this.renderChart({
      labels: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
      datasets: [
        {
          label: 'My First dataset',
          backgroundColor: hexToRgba(brandInfo, 10),
          borderColor: brandInfo,
          pointHoverBackgroundColor: '#fff',
          borderWidth: 2,
          data: data1
        },
        {
          label: 'My Second dataset',
          backgroundColor: 'transparent',
          borderColor: brandSuccess,
          pointHoverBackgroundColor: '#fff',
          borderWidth: 2,
          data: data2
        },
        {
          label: 'My Third dataset',
          backgroundColor: 'transparent',
          borderColor: brandDanger,
          pointHoverBackgroundColor: '#fff',
          borderWidth: 1,
          borderDash: [8, 5],
          data: data3
        }
      ]
    }, {
      tooltips: {
        enabled: false,
        custom: CustomTooltips,
        intersect: true,
        mode: 'index',
        position: 'nearest',
        callbacks: {
          labelColor: function (tooltipItem, chart) {
            return { backgroundColor: chart.data.datasets[tooltipItem.datasetIndex].borderColor }
          }
        }
      },
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines: {
            drawOnChartArea: false
          }
        }],
        yAxes: [{
          ticks: {
            beginAtZero: true,
            maxTicksLimit: 5,
            stepSize: Math.ceil(250 / 5),
            max: 250
          },
          gridLines: {
            display: true
          }
        }]
      },
      elements: {
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3
        }
      }
    })
  }
}

function random (min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min)
}

</script>

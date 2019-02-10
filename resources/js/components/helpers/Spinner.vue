<template>
  <div class="text-center">
    <svg :width="width"  :height="height" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-rolling" style="background: none; shape-rendering: auto;">
      <circle cx="50" cy="50" fill="none" ng-attr-stroke="" ng-attr-stroke-width="" ng-attr-r="" ng-attr-stroke-dasharray="" :stroke="color" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138" class="" transform="rotate(53.9402 50 50)">
        <animateTransform attributeName="transform" type="rotate" calcMode="linear" values="0 50 50;360 50 50" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite" class=""></animateTransform>
      </circle>
    </svg>
  </div>
</template>

<script>

export default {
  name: 'Spinner',
  props: {
    color: {
      type: String,
      default: '#20a8d8',
    },
    height: {
      type: String,
      default: '72px'
    },
    width: {
      type: String,
      default: '72px'
    }
  },
}

</script>

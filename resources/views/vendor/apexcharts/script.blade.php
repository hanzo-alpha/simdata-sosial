<script type="text/javascript">
    const options = {!! $chart->getOptions() !!};

    const chart_{{ $chart->getId() }} = new ApexCharts(document.querySelector("#{!! $chart->getId() !!}"),
        options);

    chart_{{ $chart->getId() }}.render();
</script>

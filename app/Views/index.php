<header class="main-header">
    <h1 class="text-center mt-5"><?= $heading ?? "Температура за 2021г." ?></h1>
</header>
<main class="main-main d-flex flex-column p-3 ">
    <div class="button-container d-inline-flex p-2">
        <button class="btn btn-info mr-2"  data-value="day">По дням</button>
        <button class="btn btn-info mr-2" data-value="week">По неделям</button>
        <button class="btn btn-info mr-2" data-value="month">По месяцам</button>
    </div>
    <div id="chart" class="chart"></div>

</main>
<footer class="main-footer">

</footer>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.min.js"></script>
<script src="/index.js" ></script>

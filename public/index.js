async function fetchAndPrepareData(period = 'day') {
    return fetch('/api/' + period)
        .then(data => data.json())
        .then(data => {
            return Object.entries(data);
        })
}

const dataSets = {
    day: undefined,
    week: undefined,
    month: undefined,
}

function createTable($data) {
    let template = `
        <table class="table table-hover">
            <thead>
                <tr>
                  <th scope="col">Дата</th>
                  <th scope="col">Исходное значение</th>
                  <th scope="col">Вычисленное значение</th>
                </tr>
            </thead>
            <tbody>
    `;
    $data.forEach(item => {
        const [date, initialVal, averageVal] = item;
        const row = `
            <tr>
                <td>${date}</td>
                <td>${initialVal}</td>
                <td>${averageVal}</td>
            </tr>
        `
        template += row
    })
    template += `
        </tbody></table>
    `
    return template
}


fetchAndPrepareData('day')
    .then(data => {
        data = data.map(item => item[1])
        dataSets.day = data
    })
    .then(() => {
        document.querySelector('#chart').innerHTML = createTable(dataSets.day)
    })
    .then(() => fetchAndPrepareData('week'))
    .then(data => {
        dataSets.week = data.map(item => item[1])
    })
    .then(() => fetchAndPrepareData('month'))
    .then(data => {
        dataSets.month = data.map(item => item[1])
    })


document.querySelector(".button-container").addEventListener("click", buttonClickHandler);

function buttonClickHandler(e) {
    const btn = e.target.closest('[data-value]')
    if (btn) {
        document.querySelector('#chart').innerHTML = createTable(dataSets[btn.dataset.value])
    }
}


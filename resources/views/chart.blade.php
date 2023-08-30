<x-main-layout title="E-Complaint | Chart Pengaduan">
    @push('my-css')
        <style>
            #chartB .apexcharts-canvas {
                margin: auto !important;
            }
        </style>
    @endpush
    <div class="card">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title text-center">Chart Pengaduan</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <div id="chartA"></div>
                </div>
                <div class="col-md-6">
                    <div id="chartB"></div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h6 class="fw-bold">Total pengaduan berdasarkan kategori per-tahun <span
                                    id="textTahun">2023</span></h6>
                        </div>
                        <div class="col d-flex">
                            <div class="spinner-border text-primary d-none" role="status" id="spinnerTahun">
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <select class="ms-2 form-select form-select-sm" id="selectTahun">
                                @foreach ($tahuns as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="chartC"></div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h6 class="fw-bold">Total pengaduan bulan <span id="textBulan">Juni</span></h6>
                        </div>
                        <div class="col d-flex">
                            <div class="spinner-border text-primary d-none" role="status" id="spinnerBulan">
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <select class="ms-2 form-select form-select-sm" id="selectBulan">
                                @foreach ($bulans as $key => $bulan)
                                    <option value="{{ $key }}">{{ $bulan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="chartD"></div>
                </div>
            </div>
        </div>
    </div>

    @push('my-js')
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="{{ asset('assets/js/chart.js') }}"></script>
        <script>
            const kategoris = {{ Js::from($kategoris) }};
            const responsePengaduanTahun = async (tahun) => await axios.get(`https://e-complaint.dev/chart/tahun/${tahun}`);
            const responsePengaduanBulan = async (bulan) => await axios.get(`https://e-complaint.dev/chart/bulan/${bulan}`);

            // Spinner
            const spinnerTahun = document.getElementById('spinnerTahun');
            const spinnerBulan = document.getElementById('spinnerBulan');

            // select
            const selectTahun = document.getElementById('selectTahun');
            const selectBulan = document.getElementById('selectBulan');

            // Text
            const textTahun = document.getElementById('textTahun');
            const textBulan = document.getElementById('textBulan');

            const chartPengaduanTahun = async (tahun) => {
                // Ganti text awal
                textTahun.innerHTML = tahun;

                const {
                    data: responseDataChart
                } = await responsePengaduanTahun(tahun);

                let dataChart = [];
                for (const key in responseDataChart) {
                    let object = {
                        name: key,
                        data: Object.values(responseDataChart[key])
                    }
                    dataChart.push(object)
                }

                chartTahunTampil(dataChart);
            }

            const chartPengaduanBulan = async (bulan) => {
                // Ganti text awal
                textBulan.innerHTML = bulan;

                const {
                    data: responseDataChart
                } = await responsePengaduanBulan(bulan);

                chartBulanTampil(responseDataChart);
            }

            chartPengaduanTahun(2023);
            chartPengaduanBulan(6);

            const optionsA = {
                chart: {
                    type: 'line',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 3000,
                    }
                },
                series: [{
                    name: 'Total',
                    data: kategoris.map((kategori) => {
                        return kategori.total_pengaduan
                    })
                }],
                xaxis: {
                    categories: kategoris.map((kategori) => {
                        return kategori.name
                    })
                },
                yaxis: {
                    title: {
                        text: "Total Pengaduan",
                    }
                },
                title: {
                    text: 'Total Pengaduan berdasarkan Kategori',
                    align: 'left'
                },
            }

            const chartA = new ApexCharts(document.querySelector("#chartA"), optionsA);
            chartA.render();

            const optionsB = {
                series: kategoris.map((kategori) => {
                    return kategori.total_pengaduan
                }),
                chart: {
                    width: 600,
                    type: 'pie',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 3000,
                    }
                },
                labels: kategoris.map((kategori) => {
                    return kategori.name
                }),
                legend: {
                    show: true,
                    fontSize: '18px',
                    position: 'right',
                    offsetY: 75,
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
            };

            const chartB = new ApexCharts(document.querySelector("#chartB"), optionsB);
            chartB.render();

            const chartTahunTampil = (dataChart) => {
                const optionsC = {
                    series: dataChart,
                    chart: {
                        type: 'bar',
                        height: 350,
                        stacked: true,
                        toolbar: {
                            show: true
                        },
                        zoom: {
                            enabled: true
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 1000,
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            borderRadius: 10,
                            dataLabels: {
                                total: {
                                    enabled: true,
                                    style: {
                                        fontSize: '13px',
                                        fontWeight: 900
                                    }
                                }
                            }
                        },
                    },
                    xaxis: {
                        categories: ["January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"
                        ],
                    },
                    legend: {
                        position: 'right',
                        offsetY: 130
                    },
                    fill: {
                        opacity: 1
                    },

                };

                const chartC = new ApexCharts(document.querySelector("#chartC"), optionsC);
                chartC.render();

                selectTahun.addEventListener('change', async (e) => {
                    textTahun.innerHTML = e.target.value;

                    spinnerTahun.classList.remove('d-none');
                    const {
                        data: responseDataChart
                    } = await responsePengaduanTahun(e.target.value);
                    spinnerTahun.classList.add('d-none');

                    let dataChart = [];
                    for (const key in responseDataChart) {
                        let object = {
                            name: key,
                            data: Object.values(responseDataChart[key])
                        }
                        dataChart.push(object)
                    }

                    chartC.updateSeries(dataChart)
                });
            }

            const chartBulanTampil = (dataChart) => {
                const optionsD = {
                    series: [{
                        name: 'Total',
                        data: Object.values(dataChart)
                    }],
                    chart: {
                        height: 350,
                        type: 'bar',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 1000,
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 10,
                            dataLabels: {
                                position: 'top', // top, center, bottom
                            },
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: ["#304758"]
                        }
                    },

                    xaxis: {
                        categories: Object.keys(dataChart),
                        position: 'bottom',
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        crosshairs: {
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    colorFrom: '#D8E3F0',
                                    colorTo: '#BED1E6',
                                    stops: [0, 100],
                                    opacityFrom: 0.4,
                                    opacityTo: 0.5,
                                }
                            }
                        },
                        tooltip: {
                            enabled: true,
                        }
                    },
                    yaxis: {
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false,
                        },
                        labels: {
                            show: false,
                        }

                    },
                };

                const chartD = new ApexCharts(document.querySelector("#chartD"), optionsD);
                chartD.render();

                selectBulan.addEventListener('change', async (e) => {
                    textBulan.innerHTML = e.target.value;

                    spinnerBulan.classList.remove('d-none');
                    const {
                        data: responseDataChart
                    } = await responsePengaduanBulan(e.target.value);
                    spinnerBulan.classList.add('d-none');

                    console.log(responseDataChart);

                    chartD.updateSeries([{
                        name: 'Total',
                        data: Object.values(responseDataChart)
                    }])
                    chartD.updateOptions({
                        xaxis: {
                            categories: Object.keys(responseDataChart),
                        }
                    });
                });
            };
        </script>
    @endpush
</x-main-layout>

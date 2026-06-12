const infoBox = document.getElementById('info')
// map responsiveness - refactoring required
const windowHeight = window.innerHeight
const windowWidth = window.innerWidth
console.log(windowHeight, windowWidth, "h x w")
let zoomValue;
if (windowHeight >= 556 && windowWidth <= 1093){
   zoomValue = 6;
}else {
   zoomValue = 7;
}

// initialize the map
var map = L.map("map", {
  center: [28.4476377, 84.5810357],
  zoom: zoomValue,
  zoomControl: false, 
  draggable: false
});

// Map Configurations ---------->
map.attributionControl.setPrefix('Town Development Fund Projects Monitoring')
map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();
map.boxZoom.disable();
map.keyboard.disable();
map.dragging.disable();

// load GEOJSON object/array to map
L.geoJSON(geojsonFeature, {
  onEachFeature: function (feature, layer) {
    // console.log(feature, "featire")
    const stateNames = [
      "प्रदेश १","मधेस प्रदेश","बागमती प्रदेश","गण्डकी प्रदेश", "लुम्बिनी प्रदेश","कर्णाली प्रदेश", "सुदुरपश्चिम प्रदेश",
    ]
    const labels = [
      "राजधानी:",
      "सम्माननीय मुख्यमन्त्री",
      "कुल क्षेत्रफल",
      "जिल्ला",
      "महानगरपािलका:",
      "उपमहानगरपािलका:",
      "नगरपािलका:",
      "गाउँपािलका:"
    ]
    const StatesInfo = [
      {
        StateName: "प्रदेश १",
        capital: "Biratnagar",
        chiefMinister: "Rajendra Kumar Rai",
        Area: "25,905 km2",
        district: "14",
        MetropolitianCities: "  -  ",
        subMetropolitianCities: "  -  ",
        Municipality: "  -  ",
        lg: "  -  ",
        provinceId: 1,
        total: 12,
        running: 6,
        completed: 4,
        halt: 2
      },
      {
        StateName: "मधेस प्रदेश",
        capital: "Janakpur",
        chiefMinister: "Lalbabu Raut",
        Area: "9,661 km2",
        district: "8",
        MetropolitianCities: "  -  ",
        subMetropolitianCities: "  -  ",
        Municipality: "  -  ",
        lg: "  -  ",
        provinceId: 2,
        total: 23,
        running: 12,
        completed: 6,
        halt: 5
      },
       {
        StateName: "बागमती प्रदेश",
        capital: "Hetauda",
        chiefMinister: "Rajendra Pandey",
        Area: "20,300 km2",
        district: "13",
        MetropolitianCities: "  -  ",
        subMetropolitianCities: "  -  ",
        Municipality: "  -  ",
        lg: "  -  ",
        provinceId: 3,
        total: 21,
         running: 10,
         completed: 8,
        halt: 3
      },
      {
        StateName: "गण्डकी प्रदेश",
        capital: "Pokhara",
        chiefMinister: "Krishna Chandra Nepali",
        Area: "21,504 km2",
        district: "11",
        MetropolitianCities: "  -  ",
        subMetropolitianCities: "  -  ",
        Municipality: "  -  ",
        lg: "  -  ",
        provinceId: 4,
        total: 15,
        running: 8,
        completed: 7,
        halt: 0
      },
      {
        StateName: "लुम्बिनी प्रदेश",
        capital: "Deukhuri",
        chiefMinister: "Kul Prasad KC",
        Area: "22,288 km2",
        district: "12",
        MetropolitianCities: "  -  ",
        subMetropolitianCities: "  -  ",
        Municipality: "  -  ",
        lg: "  -  ",
        provinceId: 5,
        total: 18,
        running: 9,
        completed: 6,
        halt: 3
      },
      {
        StateName: "कर्णाली प्रदेश",
        capital: "Birendranagar",
        chiefMinister: "Jeevan Bahadur Shahi",
        Area: "27,984 km2",
        district: "10",
        MetropolitianCities: "  -  ",
        subMetropolitianCities: "  -  ",
        Municipality: "  -  ",
        lg: "  -  ",
        provinceId: 6,
        total: 32,
        running: 16,
        completed: 10,
        halt: 6
      },
      {
        StateName: "सुदुरपश्चिम प्रदेश",
        capital: "Godawari",
        chiefMinister: "Trilochan Bhatta",
        Area: "19,915 km2",
        district: "9",
        MetropolitianCities: "  -  ",
        subMetropolitianCities: "  -  ",
        Municipality: "  -  ",
        lg: "  -  ",
        provinceId: 7,
        total: 16,
        running: 8,
        completed: 6,
        halt: 2
      }

    ]
    const ProvinceName = feature?.properties?.PR_NAME
    if (feature.properties) layer.bindTooltip(ProvinceName, {direction: "top"}) // bind tooltip to each feature
    const ProvinceColors = ["#0F52BA"]
    // const ProvinceColors = ["#215D93"]
    const formula = Math.floor(Math.random() * ProvinceColors.length) // get a random index from the array
    layer.setStyle({
        fillColor: ProvinceColors[formula],
        fillOpacity: 1,
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '1',
        fillOpacity: 0.7
      })
    document.getElementById("provinceName").innerHTML =  "प्रदेश"
    function OnFeatureClick(e) {
      // geojsonFeature.resetStyle(e.target.layer);
      const ClickedOn = e?.target?.feature?.properties?.PROVINCE
      document.getElementById("provinceName").innerHTML = ProvinceName 
    function getProvinceInfo(id) {
      // layer.setStyle({fillColor : ProvinceColors[id]}) // to set one color for every layer
      if (id === 1) {
      // console.log(e?.target?.feature?.properties)
      // document.getElementById("provinceName").innerHTML = StatesInfo[0].StateName;
      document.getElementById("total").innerHTML = StatesInfo[0].total
      document.getElementById("running").innerHTML = StatesInfo[0].running
      document.getElementById("completed").innerHTML = StatesInfo[0].completed
      document.getElementById("halt").innerHTML = StatesInfo[0].halt
      // document.getElementById("secondvalue").innerHTML = StatesInfo[0].chiefMinister
      // document.getElementById("thirdvalue").innerHTML = StatesInfo[0].Area
      // document.getElementById("fourthvalue").innerHTML = StatesInfo[0].district
      // document.getElementById("fifthvalue").innerHTML = StatesInfo[0].MetropolitianCities
      // document.getElementById("sixthvalue").innerHTML = StatesInfo[0].subMetropolitianCities
      // document.getElementById("seventhvalue").innerHTML = StatesInfo[0].Municipality
      // document.getElementById("eighthvalue").innerHTML = StatesInfo[0].lg
      } else if (id === 2) {
      // document.getElementById("provinceName").innerHTML = StatesInfo[1].StateName;
      document.getElementById("total").innerHTML = StatesInfo[1].total
      document.getElementById("running").innerHTML = StatesInfo[1].running
      document.getElementById("completed").innerHTML = StatesInfo[1].completed
      document.getElementById("halt").innerHTML = StatesInfo[1].halt
      // document.getElementById("secondvalue").innerHTML = StatesInfo[1].chiefMinister
      // document.getElementById("thirdvalue").innerHTML = StatesInfo[1].Area
      // document.getElementById("fourthvalue").innerHTML = StatesInfo[1].district
      // document.getElementById("fifthvalue").innerHTML = StatesInfo[1].MetropolitianCities
      // document.getElementById("sixthvalue").innerHTML = StatesInfo[1].subMetropolitianCities
      // document.getElementById("seventhvalue").innerHTML = StatesInfo[1].Municipality
      // document.getElementById("eighthvalue").innerHTML = StatesInfo[1].lg
      } else if (id === 3) {
      // document.getElementById("provinceName").innerHTML = StatesInfo[2].StateName;
      document.getElementById("total").innerHTML = StatesInfo[2].total
      document.getElementById("running").innerHTML = StatesInfo[2].running
      document.getElementById("completed").innerHTML = StatesInfo[2].completed
      document.getElementById("halt").innerHTML = StatesInfo[2].halt
      // document.getElementById("secondvalue").innerHTML = StatesInfo[2].chiefMinister
      // document.getElementById("thirdvalue").innerHTML = StatesInfo[2].Area
      // document.getElementById("fourthvalue").innerHTML = StatesInfo[2].district
      // document.getElementById("fifthvalue").innerHTML = StatesInfo[2].MetropolitianCities
      // document.getElementById("sixthvalue").innerHTML = StatesInfo[2].subMetropolitianCities
      // document.getElementById("seventhvalue").innerHTML = StatesInfo[2].Municipality
      // document.getElementById("eighthvalue").innerHTML = StatesInfo[2].lg
      } else if (id === 4) {
        // document.getElementById("provinceName").innerHTML = StatesInfo[3].StateName;
      document.getElementById("total").innerHTML = StatesInfo[3].total
      document.getElementById("running").innerHTML = StatesInfo[3].running
      document.getElementById("completed").innerHTML = StatesInfo[3].completed
      document.getElementById("halt").innerHTML = StatesInfo[3].halt
      // document.getElementById("secondvalue").innerHTML = StatesInfo[3].chiefMinister
      // document.getElementById("thirdvalue").innerHTML = StatesInfo[3].Area
      // document.getElementById("fourthvalue").innerHTML = StatesInfo[3].district
      // document.getElementById("fifthvalue").innerHTML = StatesInfo[3].MetropolitianCities
      // document.getElementById("sixthvalue").innerHTML = StatesInfo[3].subMetropolitianCities
      // document.getElementById("seventhvalue").innerHTML = StatesInfo[3].Municipality
      // document.getElementById("eighthvalue").innerHTML = StatesInfo[3].lg
      } else if (id === 5) {
      // document.getElementById("provinceName").innerHTML = StatesInfo[4].StateName;
      document.getElementById("total").innerHTML = StatesInfo[4].total
      document.getElementById("running").innerHTML = StatesInfo[4].running
      document.getElementById("completed").innerHTML = StatesInfo[4].completed
      document.getElementById("halt").innerHTML = StatesInfo[4].halt
      // document.getElementById("secondvalue").innerHTML = StatesInfo[4].chiefMinister
      // document.getElementById("thirdvalue").innerHTML = StatesInfo[4].Area
      // document.getElementById("fourthvalue").innerHTML = StatesInfo[4].district
      // document.getElementById("fifthvalue").innerHTML = StatesInfo[4].MetropolitianCities
      // document.getElementById("sixthvalue").innerHTML = StatesInfo[4].subMetropolitianCities
      // document.getElementById("seventhvalue").innerHTML = StatesInfo[4].Municipality
      // document.getElementById("eighthvalue").innerHTML = StatesInfo[4].lg
      } else if (id === 6) {
        // document.getElementById("provinceName").innerHTML = StatesInfo[5].StateName;
      document.getElementById("total").innerHTML = StatesInfo[5].total
      document.getElementById("running").innerHTML = StatesInfo[5].running
      document.getElementById("completed").innerHTML = StatesInfo[5].completed
      document.getElementById("halt").innerHTML = StatesInfo[5].halt
      // document.getElementById("secondvalue").innerHTML = StatesInfo[5].chiefMinister
      // document.getElementById("thirdvalue").innerHTML = StatesInfo[5].Area
      // document.getElementById("fourthvalue").innerHTML = StatesInfo[5].district
      // document.getElementById("fifthvalue").innerHTML = StatesInfo[5].MetropolitianCities
      // document.getElementById("sixthvalue").innerHTML = StatesInfo[5].subMetropolitianCities
      // document.getElementById("seventhvalue").innerHTML = StatesInfo[5].Municipality
      // document.getElementById("eighthvalue").innerHTML = StatesInfo[5].lg
      }else {
        // document.getElementById("provinceName").innerHTML = StatesInfo[6].StateName;
      document.getElementById("total").innerHTML = StatesInfo[6].total
      document.getElementById("running").innerHTML = StatesInfo[6].running
      document.getElementById("completed").innerHTML = StatesInfo[6].completed
      document.getElementById("halt").innerHTML = StatesInfo[6].halt
      // document.getElementById("secondvalue").innerHTML = StatesInfo[6].chiefMinister
      // document.getElementById("thirdvalue").innerHTML = StatesInfo[6].Area
      // document.getElementById("fourthvalue").innerHTML = StatesInfo[6].district
      // document.getElementById("fifthvalue").innerHTML = StatesInfo[6].MetropolitianCities
      // document.getElementById("sixthvalue").innerHTML = StatesInfo[6].subMetropolitianCities
      // document.getElementById("seventhvalue").innerHTML = StatesInfo[6].Municipality
      // document.getElementById("eighthvalue").innerHTML = StatesInfo[6].lg
      }}
      ClickedOn && getProvinceInfo(ClickedOn)
    }
    layer.on({
        mousemove: OnFeatureClick,
        // click: OnFeatureClick
    })
  },
}).addTo(map)
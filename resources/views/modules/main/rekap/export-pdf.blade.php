<html>
<head>
    <title>Rekap</title>
<style>
        @page {
            /* margin: 60px 25px; */
        }

       /* Define now the real margins of every page in the PDF */
       body {
           margin-top: 0cm;
           margin-left: 1cm;
           margin-right: 0cm;
           margin-bottom: -1.5cm;
           font-style: normal;
       }
        
        .dont-break-me{
            page-break-inside: avoid;
        }
            /* Create four equal columns that floats next to each other */
        .column {
            float: right;
            width: 15%;
        }
            /* Clear floats after the columns */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        #outtable{
          /*padding: 20px;*/
          border:0px;
          width:500px;
          /*border-radius: 5px;*/
        }
        
        .ui.table.no-border {
         border: 0px;
         border-collapse: collapse;
         width: 100%;
         font-family : "Arial", "Verdana", sans-serif;
       }

       .ui.table.bordered {
         border: solid black 1px;
         border-collapse: collapse;
         width: 100%;
         font-family : "Arial", "Verdana", sans-serif;
       }

       .ui.table.bordered td {
         border: solid black .5px;
         border-collapse: collapse;
         /*padding:10px;*/
         padding:5px;
       }

       .ui.table.bordered td {
         border: solid black .5px;
         border-collapse: collapse;
         /*padding:10px;*/
         padding:5px;
       }

       .ui.table.bordered-line {
         border: solid black 1px;
         border-collapse: collapse;
         width: 100%;
         font-family : "Arial", "Verdana", sans-serif;
       }

       .ui.table.bordered-line td {
         border-bottom: solid black .5px;
         border-collapse: collapse;
         /*padding:10px;*/
         padding:5px;
       }

        .ui.table.bordered-detail {
         border: solid black 1px;
         border-collapse: collapse;
         width: 500px;
         font-family : "Arial", "Verdana", sans-serif;
       }

       .ui.table.bordered-detail td {
         border-bottom: solid black .5px;
         border-collapse: collapse;
         /*padding:10px;*/
         padding:5px;
       }

        .ui.table.bordered-dalam {
         border: solid black 1px;
         border-collapse: collapse;
         width: 100%;
         font-family : "Arial", "Verdana", sans-serif;
         padding: 0px;
       }

       .inside {
         font-style: bold;
         text-align: center;
       }

       /*.ui.table.bordered td img {
         padding: 5px;
       }*/

       .center.aligned {
         text-align : center;
       }

       .right.aligned {
         text-align : right;
       }

       .top.aligned {
         vertical-align : top;
       }

       .checkbox.field{
         height: 17px !important;
       }
       .checkbox.field:last-child{
         margin-bottom: 5px !important;
       }
       .checkbox.field label{
         vertical-align: 3px;
       }

        input[type=checkbox] { display: inline; }
       /* Define the header rules */
        header {
            position: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            height: 10px;

            /* Extra personal styles */
            text-align: center;
            /*line-height: 35px;*/

            font-size: 11px;
        }
        
       main {
         position: sticky;
         font-size : 12px;
         padding-top : 1cm;
         margin-top : 30px;
         border : solid black 2px;
         width: 100%;
       }

       main p {
         margin-left: 5px;
         margin-right: 5px;
       }

       /* Define the footer rules */
       footer {
           position: fixed;
           bottom: -60px;
           left: 0px;
           right: 0px;
           height: 50px;

           /* Extra personal styles */
           text-align: center;
           line-height: 35px;
       }
       .footer .page-number:after {
         content: counter(page);
       }

        tr.inverted{
            background-color: #000000;
        }
        .inverted th{
            color: white;
        }

        tr.active{
            background-color: #E0E0E0;
        }

        .compact.cell{
            font-size: 8px;
            padding: 0 5px !important;
            height: 15px !important;
        }
</style>
</head>
<body>
    <h4 style="text-align: center">Rekap Kehadiran</h4>
    <h5 style="text-align: center; margin-top:-15px">Per {{ Carbon::parse($tanggal)->formatLocalized("%B %Y")}}</h5>
    <table class="ui table bordered" style="font-size: 10px">
       <thead>
         <tr style="font-weight: bold">
           <td>No</td>
           <td>Nama</td>
           <td>Area</td>
           <td>Hadir</td>
           <td>Izin</td>
           <td>Sakit</td>
           {{-- <td>Cuti</td>
           <td>Tanpa Keterangan</td> --}}
         </tr>
       </thead>
       <tbody>
         @foreach ($record as $item)
          <tr>
            <td>{{$loop->iteration}}.</td>
            <td>{{$item->name}}</td>
            <td>{{$item->area}}</td>
            <td>{{$item->hadir()}}</td>
            <td>{{$item->izin()}}</td>
            <td>{{$item->sakit()}}</td>
            {{-- <td>{{$item->absen ? ($item->absen->latitude ? $item->absen->latitude.' , '.$item->absen->longitude : '-' ): '-' }}</td>
            <td>{{$item->alfa($tanggal)}}</td> --}}
          </tr>
         @endforeach
       </tbody>
    </table>
  
    

    <footer>
        <script type="text/php">
            if (isset($pdf)) {
              $font = $fontMetrics->getFont("Arial", "bold");
              $pdf->page_text(545, 820, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 8, array(0, 0, 0));
            }
          </script>
    </footer>
</body> 
    
</html>
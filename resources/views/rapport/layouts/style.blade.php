<style>
    body {
        font-size: 0.9em;
        line-height: 1.2;
        font-family: 'Montserrat', sans-serif;
        letter-spacing: 1.2px;
        color: #32325d;
        background-color: white;
    }

    h2 {
        color: #00ada7;
        font-weight: 600;
        text-align: left;
        font-size: 2em !important;
    }
    p{
        font-weight: 500;
    }
    h3,
        /*b {*/
        /*    color: #dee2e6;*/
        /*}*/

    td,
    th {
        border: 1px solid #dee2e6;
        padding: 0.5em;

    }

    th{
        font-weight:700;
    }

    table {
        border-collapse: collapse;
    }
    .titre-rapport {
        text-align: center;
        text-transform: uppercase;
        color:#00ada7;
        font-weight: 900;
    }
    .sous-titre-rapport {
        text-transform: uppercase;
        color:#00ada7;
        /*font-size:0.8em;*/
    }

    .sous-titre-rapport::after{
        content:"";
        display:block;
        width:60%;
        height:0.5px;
        font-weight: 600;
        background-color:#dee2e6;
        /* margin:0 auto;*/
        margin-top:3em;
    }

    .logo-rapport{
        width:200px;
        heigth: auto;
    }

    .rapport-logo-wrapper{
        margin-left:39%;

    }
    .title-table{
        font-weight : 600;

    }
    .sous-titre-rapport--table{
        text-transform: uppercase;
        color:#00ada7;
        font-size:0.8em;
    }
    /* DivTable.com */
    .divTable {
        display: table;
        width: 100%;
    }

    .divTableRow {
        display: table-row;
    }

    .divTableHeading {
        /*background-color: #eee;*/
        display: table-header-group;
    }

    .divTableCell,
    .divTableHead {
        /*border: 1px solid #999999;*/
        display: table-cell;
        padding: 3px 10px;
    }

    .divTableHeading {
        /*background-color: #eee;*/
        display: table-header-group;
        font-weight: bold;
    }

    .divTableFoot {
        /*background-color: #eee;*/
        display: table-footer-group;
        font-weight: bold;
    }

    .divTableBody {
        display: table-row-group;
    }
    .noBorder {
        border:none !important;
    }
    .welcome{
       background-color: #F0F0F0;
       border-style: dotted;
       border-color:#00ADA7;
       padding: 0px 50px;
       text-align: center;
    }
    .welcom p {
        margin: 10 px;
    }
    .row {
        height:150px;
        display:inline-block;
      /*  display: flex;
        justify-content: space-around;*/
    }
    .col-right{
        right: 0px;
        position:absolute;
        right:0px;
        width: 200px;
        text-align: center;
    }
    .col-left{
        margin-left:0px;
        position:absolute;
        left:0px;
        width:50%;
    }
    .container-doc{
        padding-left:2px;
        padding-right:2px;
    }
    .textVert{
        color:#00ADA7;
        font-family: 'Montserrat', sans-serif;
    }
    .textDate{
        line-height: 1.6;
        font-size:20px;
        color:#00ADA7;
    }
    .textViolet{
        color:rgb(50, 50, 93);
    }
    .textBlack{
        color:#A1A1A1;
    }
    .rubrique-title{
        background-color: #00ADA7;
        height:33px;
        color:#FFF;
        font-size:17px;
        text-transform: uppercase;
        text-align:center;
    }
    .date span{
        color:rgb(50, 50, 93);
        font-size:20px;
    }
    .date {
        font-style: italic;
    }
    .separator{
        margin:0 auto;
        width:250px;
        padding-left: 50px;
    }
    .row-flex{
        display:flex;
    }
  
        .wrapper-page{
            page-break-after: auto;
        }
        .wrapper-page:last-child{
            page-break-after: inherit;
        }
  
    @page { size: a4 portrait; }
   
</style>

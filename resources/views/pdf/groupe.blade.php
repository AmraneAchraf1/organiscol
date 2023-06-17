<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Emploi Groupe</title>
</head>
<style>
    * {

        box-sizing: border-box;
    }
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
    }
    .annee-formation table{
        border: 1px black solid;
        border-collapse: collapse;

    }
    .emploi {
        border: 1px black solid;
        border-collapse: collapse;
        width: 100%;

        margin-top: 30px;
    }
    .emploi th {
        border: 2px black solid;
        border-collapse: separate;
        padding:  16px;
        font-size: 16px;
    }
    .emploi td {
        border: 1.8px black solid;
        text-align: center;
        height: 64px;
        font-size: 14px;
    }

    .groupe {

        font-weight: bold;
        margin: 0;
        margin-bottom: 4px;
        font-size: 16px;
    }
    .salle {
        margin: 0;
        font-weight: bold;

        font-size: 16px;
    }
</style>
<body>
<htmlpageheader name="page-header">
    <div class="header">
        <table
            cellpadding="0"
            cellspacing="0"
        >
            <tr>
                <td class="header-left"
                    style="width: 320px;"
                >
                    <div class="logo">
                        <img src="{{ public_path('assets/images/ofppt.png') }}"
                             style="padding: 0; margin: 0"
                             width="82" alt="logo">

                    </div>
                    <div class="description" style="padding-top: 2px;margin-top: 4px">
                        <h5 style="padding: 0; margin: 0">DRO/CF TAOURIRT - GUERCIF </h5>
                        <h5 style="padding: 0; margin:2px 0;">ISTA  TAOURIRT</h5>
                        <h5 style="padding: 0; margin:0">Groupe : <span style="text-transform: capitalize;border: 1px black solid;padding: 2px 6px;margin-left: 24px;font-size: 14px"> {{$groupe}} </span></h5>


                    </div>
                </td>

                <td class="header-middle"
                    style="width: 516px;text-align: center;padding-top:111px;"
                >
                    <h2
                        style="margin: 0; padding: 0; font-size: 24px;text-align: center;padding-bottom: 32px;margin-right: 106px;"
                    >
                        Emploi du temps du groupe
                    </h2>
                     <span style="text-align: center;border: 1.5px solid black; padding: 4px 40px">
                         Masse Horaire hebdomadaire
                     </span>
                    <span>
                         {{$masse_horaire}} heures
                     </span>
                </td>

                <td class="header-right"
                    style="width: 180px;padding-top: 95px;"
                >
                    <div class="annee-formation" >
                        <table
                            width="132"
                        >
                            <tr
                                style="background: #edf2f7;border: 1px solid #000000;"
                            >
                                <td>
                                    <h4 style="padding: 0; margin: 0;text-align: center">Année de formation  </h4>
                                </td>
                            </tr>
                            <tr>
                                <h3 style="padding: 0; margin: 0; text-align: center">{{$annee_formation}}</h3>
                            </tr>

                        </table>
                        <h4
                            style="padding: 0; margin: 0;text-align: center;margin-top: 12px"
                        >
                           {{Carbon\Carbon::now()->format('d/m/Y')}}
                        </h4>
                    </div>
                </td>
            </tr>

        </table>
    </div>
</htmlpageheader>


<table class="emploi">
    <thead>
    <tr

    >

        <th style="border-top: white 1px solid;border-left: white 1px solid"></th>
        <th> 8H ----------> 11H </th>
        <th
            style="border-left: 3.5px solid black;"
        > 11H ----------> 13H30 </th>
        <th
            style="border-left: 6px solid black;"
        > 13H30 ----------> 16H </th>
        <th
            style="border-left: 3.5px solid black;"
        > 16H ----------> 18H30 </th>
    </tr>
    </thead>
    <tbody>
    <tr

    >
        <td
            style="border-top: 1px solid #000000; "
        >Lundi</td>
        <td>
            @if (isset($data['lundi']["1"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['lundi']["1"][0]->formateur->nom}} {{$data['lundi']["1"][0]->formateur->prenom}}
                </h5>


                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['lundi']["1"][0]->salle->nom}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['lundi']["2"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['lundi']["2"][0]->formateur->nom ?? ''}} {{$data['lundi']["2"][0]->formateur->prenom ?? ''}}
                </h5>


                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['lundi']["2"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 6px solid black;"
        >
            @if (isset($data['lundi']["3"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['lundi']["3"][0]->formateur->nom ?? ''}} {{$data['lundi']["3"][0]->formateur->prenom ?? ''}}
                </h5>


                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['lundi']["3"][0]->salle->nom ?? ''}}
                </h5>
            @endif

        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['lundi']["4"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['lundi']["4"][0]->formateur->nom ?? ''}} {{$data['lundi']["2"][0]->formateur->prenom ?? ''}}
                </h5>


                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['lundi']["4"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
    </tr>
    <tr>
        <td>Mardi</td>
        <td>
            @if (isset($data['mardi']["1"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['mardi']["1"][0]->formateur->nom ?? ''}} {{$data['mardi']["1"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['mardi']["1"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['mardi']["2"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['mardi']["2"][0]->formateur->nom ?? ''}} {{$data['mardi']["2"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['mardi']["2"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 6px solid black;"
        >
            @if (isset($data['mardi']["3"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['mardi']["3"][0]->formateur->nom ?? ''}} {{$data['mardi']["3"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['mardi']["3"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['mardi']["4"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['mardi']["4"][0]->formateur->nom ?? ''}} {{$data['mardi']["4"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['mardi']["4"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
    </tr>
    <tr>
        <td>Mercredi</td>
        <td>
            @if (isset($data['mercredi']["1"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['mercredi']["1"][0]->formateur->nom ?? ''}} {{$data['mercredi']["1"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['mercredi']["1"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['mercredi']["2"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['mercredi']["2"][0]->formateur->nom ?? ''}} {{$data['mercredi']["2"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['mercredi']["2"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 6px solid black;"
        >
            @if (isset($data['mercredi']["3"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['mercredi']["3"][0]->formateur->nom ?? ''}} {{$data['mercredi']["3"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['mercredi']["3"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['mercredi']["4"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['mercredi']["4"][0]->formateur->nom ?? ''}} {{$data['mercredi']["4"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['mercredi']["4"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
    </tr>
    <tr>
        <td>Jeudi</td>
        <td>
            @if (isset($data['jeudi']["1"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['jeudi']["1"][0]->formateur->nom ?? ''}} {{$data['jeudi']["1"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['jeudi']["1"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['jeudi']["2"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['jeudi']["2"][0]->formateur->nom ?? ''}} {{$data['jeudi']["2"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['jeudi']["2"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 6px solid black;"
        >
            @if (isset($data['jeudi']["3"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['jeudi']["3"][0]->formateur->nom ?? ''}} {{$data['jeudi']["3"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['jeudi']["3"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['jeudi']["4"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['jeudi']["4"][0]->formateur->nom ?? ''}} {{$data['jeudi']["4"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['jeudi']["4"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
    </tr>
    <tr>
        <td>Vendredi</td>
        <td>
            @if (isset($data['vendredi']["1"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['vendredi']["1"][0]->formateur->nom ?? ''}} {{$data['vendredi']["1"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['vendredi']["1"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['vendredi']["2"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['vendredi']["2"][0]->formateur->nom ?? ''}} {{$data['vendredi']["2"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['vendredi']["2"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 6px solid black;"
        >
            @if (isset($data['vendredi']["3"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['vendredi']["3"][0]->formateur->nom ?? ''}} {{$data['vendredi']["3"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['vendredi']["3"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['vendredi']["4"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['vendredi']["4"][0]->formateur->nom ?? ''}} {{$data['vendredi']["4"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>   {{$data['vendredi']["4"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
    </tr>
    <tr>
        <td>Samedi</td>
        <td>
            @if (isset($data['samedi']["1"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['samedi']["1"][0]->formateur->nom ?? ''}} {{$data['samedi']["1"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span> {{$data['samedi']["1"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['samedi']["2"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['samedi']["2"][0]->formateur->nom ?? ''}} {{$data['samedi']["2"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle : </span>{{$data['samedi']["2"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 6px solid black;"
        >
            @if (isset($data['samedi']["3"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['samedi']["3"][0]->formateur->nom ?? ''}} {{$data['samedi']["3"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle :</span> {{$data['samedi']["3"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
        <td
            style="border-left: 3.5px solid black;"
        >
            @if (isset($data['samedi']["4"][0]))
                <h5
                    class="groupe"
                >
                    <span style="font-size: 13px">Formateur :</span> {{$data['samedi']["4"][0]->formateur->nom ?? ''}} {{$data['samedi']["4"][0]->formateur->prenom ?? ''}}
                </h5>
                <h5
                    class="salle"
                >
                    <span style="font-size: 13px">Salle :</span> {{$data['samedi']["4"][0]->salle->nom ?? ''}}
                </h5>
            @endif
        </td>
    </tr>
    </tbody>


</table>

<htmlpagefooter name="page-footer">
    <div class="footer">
        N.B/ Le présent emploi du temps peut subir un changement, si nécessaire par la direction de l’établissement.
    </div>
</htmlpagefooter>

</body>
</html>

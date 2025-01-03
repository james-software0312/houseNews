<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task</title>

    <style>
      .container{
        padding: 5px;
      }
      table {
        border-spacing: 0px;
        border-collapse: separate;
        table-layout: fixed;
      }
      td {
        text-align: center;
        font-size: 18px;
      }
      .border{
        border: 1px solid black;
      }
      .border-left{
        border-left: 1px solid black;
      }
      .border-right{
        border-right: 1px solid black;
      }
      .border-top{
        border-top: 1px solid black;
      }
      .border-bottom{
        border-bottom: 1px solid black;
      }
      .border-right-0{
        border-right: 0px;
      }

      .comment {
        font-style: italic;
        font-size: small;
        color: gray;
        height: 20px;
        line-height: 20px;
      }

      .vertical-text {
        transform: rotate(-90deg);
        font-weight: bold;
        text-align: center;
        justify-content: center;
        display: grid;
      }
      .row_pdf{
        display: flex;
        flex-wrap: wrap;
        width: 100%;
      }
      .d-flex{
        display: flex;
      }
      .col-8_pdf{
        width: 66.66%
      }
      .col-6_pdf{
        width: 50%
      }
      .col-4_pdf{
        width: 33.33%
      }
      .mt-2{
        margin-top: 20px;
      }
      .mt-4{
        margin-top: 40px;
      }
      .mt-6{
        margin-top: 60px;

      }
      .mb-2{
        margin-bottom: 20px;
      }
      .idcard-img {
        max-width: 400px;
        max-height: 250px;
      }
    </style>
</head>

<body>

  <div class="container">
    <div style="text-align: center">
      <h3>
        COMUNICAZIONE DI OSPITALITA’<br />
        IN FAVORE DI CITTADINO EXTRACOMUNITARIO
      </h3>
      <div style="font-size: small">
        (ARTICOLO 7 DEL DECRETO LEGISLATIVO 25 LUGLIO 1998 NR. 286)
      </div>
    </div>
    <div class="row_pdf mt-2" style="font-weight: bold">Il sottoscritto</div>

    <table style="width:100%">
      <tr>
        <td rowspan="5" class="border border-right-0" style="height:150px;">
          <div class="vertical-text">DICHIARANTE</div>
        </td>
        <td colspan="6" class="border border-right-0">{{ $task->owner_first_name }}</td>
        <td colspan="6" class="border">{{ $task->owner_last_name }}</td>
      </tr>
      <tr>
        <td colspan="6" class="comment">(Cognome)</td>
        <td colspan="6" class="comment">(nome)</td>
      </tr>
      <tr>
        <td class="border border-right-0">
          <div style="font-size: 10px;">GG</div>
          <div>{{ \Carbon\Carbon::parse($task->owner_birthday)->format('d') }}</div>
        </td>
        <td class="border border-right-0">
          <div style="font-size: 10px;">MM</div>
          <div>{{ \Carbon\Carbon::parse($task->owner_birthday)->format('m') }}</div>
        </td>
        <td colspan="2" class="border border-right-0">
          <div style="font-size: 10px;">AA</div>
          <div>{{ \Carbon\Carbon::parse($task->owner_birthday)->format('Y') }}</div>
        </td>
        <td colspan="4" class="border border-right-0">{{ $task->owner_birth_city }}</td>
        <td colspan="4" class="border">{{ $task->owner_birth_country }}</td>
      </tr>
      <tr>
        <td colspan="4" class="comment">(Data di nascita)</td>
        <td colspan="4" class="comment">(Comune di nascita)</td>
        <td colspan="4" class="comment">(Provincia o nazione estera)</td>
      </tr>
      <tr>
        <td colspan="12" class="border">{{ $task->owner_address }}</td>
      </tr>
      <tr>
        <td colspan="1"></td>
        <td colspan="13" class="comment">(Residenza – Comune, provincia, via o piazza, nr. civico)
        </td>
      </tr>
    </table>
    <div class="row_pdf mt-2">
      <div class="col-8_pdf" style="float: left;">
        <div style="font-weight: bold">
          ai sensi dell’art. 7 del D.lvo nr. 286/98, DICHIARA CHE DAL
        </div>
      </div>
      <div class="col-4_pdf p-0" style="float: left;">
        <table class="border" style="width: 100%">
          <tr>
            <td class="border-right border-bottom">
              <div style="font-size: smaller">GG</div>
              {{ \Carbon\Carbon::parse($task->start_date)->format('d') }}
            </td>
            <td class="border-right border-bottom">
              <div style="font-size: smaller">MM</div>
              {{ \Carbon\Carbon::parse($task->start_date)->format('m') }}
            </td>
            <td class="border-right border-bottom">{{ substr($task->start_date, 0, 1) }}</td>
            <td class="border-right border-bottom">{{ substr($task->start_date, 1, 1) }}</td>
            <td class="border-right border-bottom">{{ substr($task->start_date, 2, 1) }}</td>
            <td class="border-bottom">{{ substr($task->start_date, 3, 1) }}</td>
          </tr>
          <tr>
            <td class="border-right">
              <div style="font-size: smaller">GG</div>
              {{ \Carbon\Carbon::parse($task->end_date)->format('d') }}
            </td>
            <td class="border-right">
              <div style="font-size: smaller">MM</div>
              {{ \Carbon\Carbon::parse($task->end_date)->format('m') }}
            </td>
            <td class="border-right">{{ substr($task->end_date, 0, 1) }}</td>
            <td class="border-right">{{ substr($task->end_date, 1, 1) }}</td>
            <td class="border-right">{{ substr($task->end_date, 2, 1) }}</td>
            <td>{{ substr($task->end_date, 3, 1) }}</td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row_pdf">
      <div style="margin-left: 200px; margin-top: -20px">
        <div><input type="checkbox" checked /> <b></b></div>
        <div><input type="checkbox" checked /> <b>E FINO AL</b></div>
        <div><input type="checkbox" /> <b>E A TEMPO INDETERMINATO</b></div>
      </div>
    </div>

    <div class="row_pdf">
      <div class="col-12_pdf">
        <div>
          <input type="checkbox" checked />
          <b> ha fornito alloggio / ospitalità</b> al Signor /alla Signora:
        </div>
        <div>
          <input type="checkbox" />
          <b
            >ha ceduto la proprietà o il godimento di beni immobili, rustici o
            urbani</b
          >
          al Signor / alla Signora:
        </div>
      </div>
    </div>
    @if($taskDetails)
    @foreach ($taskDetails as $taskDetail)
      @if($taskDetail->status == 2)
        <table style="width:100%" class="mt-2" >
          <tr>
            <td rowspan="9" class="border border-right-0" style="height:420px;">
              <div class="vertical-text">CESSIONARIO<br/>
                <span style="white-space: nowrap">CITTADINO EXTRACOMUNITARIO</span>
              </div>
            </td>
            <td colspan="6" class="border border-right-0">{{ $taskDetail->guest_first_name }}</td>
            <td colspan="6" class="border">{{ $taskDetail->guest_first_name }}</td>
          </tr>
          <tr>
            <td colspan="6" class="comment">(Cognome)</td>
            <td colspan="6" class="comment">(nome)</td>
          </tr>
          <tr>
            <td class="border border-right-0">
              <div style="font-size: 10px;">GG</div>
              <div> {{ \Carbon\Carbon::parse($taskDetail->guest_birthday)->format('d') }}</div>
            </td>
            <td class="border border-right-0">
              <div style="font-size: 10px;">MM</div>
              <div> {{ \Carbon\Carbon::parse($taskDetail->guest_birthday)->format('m') }}</div>
            </td>
            <td colspan="2" class="border border-right-0">
              <div style="font-size: 10px;">AA</div>
              <div> {{ \Carbon\Carbon::parse($taskDetail->guest_birthday)->format('Y') }}</div>
            </td>
            <td colspan="4" class="border border-right-0">{{ $taskDetail->guest_birth_city }}</td>
            <td colspan="4" class="border">{{ $taskDetail->guest_birth_country }}</td>
          </tr>
          <tr>
            <td colspan="4" class="comment">(Data di nascita)</td>
            <td colspan="4" class="comment">(Comune di nascita)</td>
            <td colspan="4" class="comment">(Provincia o nazione estera)</td>
          </tr>

          <tr>
            <td colspan="4" class="border border-right-0">{{ $taskDetail->guest_nationality }}</td>
            <td colspan="8" class="border">{{ $taskDetail->guest_address }}</td>
          </tr>
          <tr>
            <td colspan="4" class="comment">(Cittadinanza)</td>
            <td colspan="8" class="comment">(residenza – Comune, provincia, via o piazza, nr. civico)</td>
          </tr>

          <tr>
            <td colspan="4" class="border border-right-0">{{ $taskDetail->id_type }}</td>
            <td colspan="4" class="border border-right-0">Number {{ $taskDetail->id_num }}</td>
            <td class="border border-right-0">
              <div style="font-size: 10px;">GG</div>
              <div>{{ \Carbon\Carbon::parse($taskDetail->id_date)->format('d') }}</div>
            </td>
            <td class="border border-right-0">
              <div style="font-size: 10px;">MM</div>
              <div>{{ \Carbon\Carbon::parse($taskDetail->id_date)->format('m') }}</div>
            </td>
            <td colspan="2" class="border">
              <div style="font-size: 10px;">AA</div>
              <div> {{ \Carbon\Carbon::parse($taskDetail->id_date)->format('Y') }}</div>
            </td>
          </tr>
          <tr>
            <td colspan="4" class="comment">(tipo documento)</td>
            <td colspan="4" class="comment">(nr. documento) </td>
            <td colspan="4" class="comment">(data di rilascio)</td>
          </tr>
          <tr>
            <td colspan="12" class="border">{{ $taskDetail->id_authority }}</td>
          </tr>
          <tr>
            <td colspan="1"></td>
            <td colspan="13" class="comment">(Residenza – Comune, provincia, via o piazza, nr. civico)
            </td>
          </tr>
        </table>

        <div class="row_pdf mt-2" style="text-align: center;">
          <div class="col-12_pdf">

            <img
              @if($taskDetail->passport)
              src="{{ public_path('storage/passports/'.$taskDetail->passport) }}"
              @else
                src="{{public_path('assets/img/id-card.png')}}"
              @endif alt="ID-CARD" class="d-block idcard-img"
              />
          </div>
        </div>

      @endif
    @endforeach
    @endif

    <div class="row_pdf">
      <div class="col-12_pdf">
        <b
          >La presente dichiarazione viene resa in qualità di
          proprietario/intestatario dell’immobile sito in :</b
        >
      </div>
    </div>
    <table style="width:100%">
      <tr>
        <td colspan="10" class="border border-right-0">{{ $task->rental_address }}</td>
        <td colspan="2" class="border"></td>
      </tr>
      <tr>
        <td colspan="10" class="comment">(Comune)</td>
        <td colspan="2" class="comment"></td>
      </tr>
      <tr>
        <td colspan="6" class="border border-right-0">{{ $task->rental_commune }}</td>
        <td colspan="2" class="border border-right-0">{{ $task->street_num }}</td>
        <td colspan="2" class="border border-right-0">{{ $task->int_num }}</td>
        <td colspan="2" class="border">{{ $task->floor }}</td>
      </tr>
      <tr>
        <td colspan="6" class="comment">(via o piazza)</td>
        <td colspan="2" class="comment">(numero)</td>
        <td colspan="2" class="comment">(interno)</td>
        <td colspan="2" class="comment">(piano)</td>
      </tr>
    </table>


    <table style="width:100%"  class=" mt-6">
      <tr>
        <td colspan="2" >Luogo e data</td>
        <td colspan="3" >
          <div class="border-bottom" style="font-weight: bold">
            ROMA {{ date('d/m/Y') }}
          </div>

        </td>
        <td colspan="3" ></td>
        <td colspan="4" >
          <div class="border-bottom" style="position: relative; height: 27px">
            <div
              class="comment"
              style="
                position: absolute;
                bottom: -22px;
                text-align: center;
                width: 100%;
              "
            >
              firma del dichiarante
            </div>
          </div>
        </td>
      </tr>
    </table>

    <div class="row_pdf mt-4 mb-2" style="width:100%;font-weight: bold; font-size: small;" >
      <div style="">
        ALLEGATI
      </div>
      <div style="margin-left: 100px;margin-top: -15px;">
        - COPIA DI UN DOCUMENTO DEL DICHIARANTE <br />
        - COPIA DI UN DOCUMENTO DEL CESSIONARIO (COPIA DEL PERMESSO DI
        SOGGIORNO IN CORSO DI VALIDITÀ O COPIA DEL PASSAPORTO - PAGINA DEI
        DATI ANAGRAFICI E DEL VISTO D’INGRESSO – UNITAMENTE A FOTOCOPIA
        RICEVUTA ASSICURATE DELLE POSTE ) <br />
        - COPIA DELLA DOCUMENTAZIONE COMPROVANTE LA PROPRIETÀ O IL TITOLO DI
        GODIMENTO DELL’IMMOBILE (ATTO DI PROPRIETÀ, CONTRATTO DI LOCAZIONE,
        ECC.) <br />
        - IL MODULO DEVE ESSERE SPEDITO CON RACCOMANDATA A/R IN DUE COPIE
        CON FIRMA IN ORIGINALE (TRATTENERE UNA TERZA COPIA)

      </div>
    </div>

    <div class="row_pdf border-top"></div>
    <div class="row_pdf mt-2">
      <div class="col-12_pdf">
        <b>ARTICOLO 7 DEL DECRETO LEGISLATIVO 25 LUGLIO 1998 NR. 286:</b>
      </div>
    </div>
    <div class="row_pdf">
      <div class="col-12_pdf" style="font-style: italic">
        “Chiunque, a qualsiasi titolo, dà alloggio ovvero ospita uno straniero
        o apolide, anche se parente o affine, o lo assume per qualsiasi causa
        alle proprie dipendenze ovvero cede allo stesso la proprietà o il
        godimento di beni immobili, rustici o urbani posti sul territorio
        dello Stato, è tenuto a darne comunicazione scritta, entro 48 ore,
        all’Autorità locale di pubblica sicurezza. Le violazioni delle
        disposizioni di cui al presente articolo sono soggette alla sanzione
        amministrativa del pagamento di una somma da 160 a 1.100 €.”
      </div>
    </div>
  </div>
</body>
</html>

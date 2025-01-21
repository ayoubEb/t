@php
    $produit = \App\Models\Produit::where("id",$id)->first();
@endphp
<h5 class="title">
  information le produit
</h5>

<div class="table-reponsive">
  <table class="table table-bordered m-0 info">
    <tbody>
      <tr>
        <td class="align-middle">
          référence
        </td>
        <td class="align-middle">
          {{ $produit->reference }}
        </td>
      </tr>
      <tr>
        <td class="align-middle">
          désignation
        </td>
        <td class="align-middle">
          {{ $produit->designation }}
        </td>
      </tr>
      <tr>
        <td class="align-middle">
          description
        </td>
        <td class="align-middle">
          {{ $produit->description }}
        </td>
      </tr>
    </tbody>
  </table>
</div>

{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\checkout.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
.drk-table-wrap{border-radius:14px;overflow:auto}
.drk-shadow{box-shadow: 0 10px 30px rgba(0,0,0,.12)}
.drk-ring{box-shadow: inset 0 0 0 1px rgba(0,0,0,.06)}
.drk-scroll::-webkit-scrollbar{height:10px}
.drk-scroll::-webkit-scrollbar-thumb{background:#232323;border-radius:9999px}
</style>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
  <h1 class="text-3xl font-extrabold tracking-tight mb-6">
    <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#e7452e] to-[#cf3d28]">Checkout</span>
  </h1>

  <div id="checkout-wrapper" class="space-y-4">
    <div id="state-empty" class="hidden">
      <div class="rounded-2xl drk-shadow drk-ring bg-[#181818] p-8 text-center">
        <p class="text-gray-400">No hay productos en el carrito.</p>
      </div>
    </div>

    <div id="state-list" class="rounded-2xl drk-shadow drk-ring bg-[#181818] p-4 sm:p-6">
      <div class="drk-table-wrap drk-scroll">
        <table class="w-full min-w-[720px] border-separate border-spacing-0">
          <thead>
            <tr class="bg-[#232323]">
              <th class="text-left text-sm font-semibold text-[#e7452e] py-3 px-4 rounded-tl-xl">Producto</th>
              <th class="text-center text-sm font-semibold text-[#e7452e] py-3 px-4">Cantidad</th>
              <th class="text-right text-sm font-semibold text-[#e7452e] py-3 px-4">Precio</th>
              <th class="text-right text-sm font-semibold text-[#e7452e] py-3 px-4">Subtotal</th>
              <th class="py-3 px-4 rounded-tr-xl"></th>
            </tr>
          </thead>
          <tbody id="checkout-body" class="divide-y divide-[#232323]"></tbody>
          <tfoot>
            <tr class="bg-[#232323] font-bold">
              <td colspan="4" class="py-4 px-4 text-right text-base font-bold rounded-bl-xl text-[#e7452e]">Total</td>
              <td class="py-4 px-4 text-right text-lg font-extrabold text-[#e7452e] rounded-br-xl" id="checkout-total">S/ 0.00</td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="mt-4 flex items-center justify-end gap-3">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-400 hover:text-[#e7452e]">
          ⟵ Seguir comprando
        </a>
        <button id="btn-continuar" class="inline-flex items-center justify-center rounded-xl px-4 py-2.5 text-sm font-semibold text-white bg-[#e7452e] hover:bg-[#cf3d28] focus:outline-none">
          Continuar
        </button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  renderCheckout();

  function renderCheckout() {
    const productos = safeParse(localStorage.getItem('cart')) || [];
    const emptyEl = document.getElementById('state-empty');
    const listEl  = document.getElementById('state-list');
    const tbody   = document.getElementById('checkout-body');
    const totalEl = document.getElementById('checkout-total');

    if (!productos.length) {
      listEl.classList.add('hidden');
      emptyEl.classList.remove('hidden');
      return;
    } else {
      listEl.classList.remove('hidden');
      emptyEl.classList.add('hidden');
    }

    let total = 0;
    tbody.innerHTML = productos.map((prod, idx) => {
      const qty = Number(prod.qty || 1);
      const price = Number(prod.price || 0);
      const subtotal = price * qty;
      total += subtotal;
      const name = escapeHtml(prod.name || 'Producto');
      const img  = prod.image ? `<img src="${prod.image}" alt="${name}" class="w-14 h-14 rounded-xl object-cover ring-1 ring-[#232323]">` : `<div class="w-14 h-14 rounded-xl bg-[#232323] ring-1 ring-[#232323]"></div>`;
      return `
        <tr class="hover:bg-[#232323] transition-colors">
          <td class="py-3 px-4">
            <div class="flex items-center gap-3">
              ${img}
              <div class="min-w-0">
                <div class="font-semibold text-[#e7452e] truncate">${name}</div>
                ${prod.sku ? `<div class="text-xs text-gray-400">SKU: ${escapeHtml(prod.sku)}</div>` : ``}
              </div>
            </div>
          </td>
          <td class="py-3 px-4 text-center">
            <span class="inline-flex items-center justify-center w-10 h-9 rounded-lg bg-[#232323] text-[#e7452e] font-semibold select-none">${qty}</span>
          </td>
          <td class="py-3 px-4 text-right text-[#e7452e]">S/ ${price.toFixed(2)}</td>
          <td class="py-3 px-4 text-right font-semibold text-[#e7452e]">S/ ${subtotal.toFixed(2)}</td>
          <td class="py-3 px-4 text-center">
            <button class="remove-btn" data-idx="${idx}" title="Quitar" style="background:none;border:none;outline:none;">
              <span class="text-[#e7452e] text-xl hover:text-[#cf3d28] font-bold cursor-pointer">&times;</span>
            </button>
          </td>
        </tr>
      `;
    }).join('');

    totalEl.textContent = `S/ ${total.toFixed(2)}`;

    // Quitar producto
    document.querySelectorAll('.remove-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const idx = Number(this.dataset.idx);
        productos.splice(idx, 1);
        localStorage.setItem('cart', JSON.stringify(productos));
        renderCheckout();
      });
    });

    document.getElementById('btn-continuar')?.addEventListener('click', () => {
      alert('Continuar con el pago');
    });
  }

  function safeParse(json){ try { return JSON.parse(json || '[]'); } catch { return []; } }
  function escapeHtml(s){ return String(s).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }
});
</script>
@endsection

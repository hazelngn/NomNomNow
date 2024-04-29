<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
   <h1 class="text-xl md:text-3xl text-accent text-center mt-11 mb-11">Check Out</h1>
   <section class="flex flex-col md:flex-row mt-3 md:w-4/6 m-auto gap-10 p-5">
      <section class="md:w-2/3">
         <form id="customerDetails" class="flex flex-col gap-2">
            <h3 class="text-accent text-xl md:text-2xl mb-2 font-bold">Continue as Guest</h3>
            <section class="flex flex-col gap-2">
               <label for="name" class="text-accent">Your name</label>
               <input type="text" id="name" name="name" class="p-2 rounded-lg bg-neutral" required>
            </section>
            <section class="flex flex-col gap-2">
               <label for="email" class="text-accent">Your email address</label>
               <input type="email" id="email" name="email" class="p-2 rounded-lg bg-neutral" required>
            </section>
            <section class="flex flex-col gap-2">
               <label for="phone" class="text-accent">Your phone number</label>
               <input type="text" id="phone" name="phone" class="p-2 rounded-lg bg-neutral" required>
            </section>
            <section>
               <h3 class="text-accent">Choose your payment type</h3>
               <div class="form-control">
                  <label class="label cursor-pointer">
                     <span class="label-text">Card</span> 
                     <input type="radio" name="payment_type" value="card" class="radio radio-accent" checked/>
                  </label>
               </div>
               <div class="form-control">
                  <label class="label cursor-pointer">
                     <span class="label-text">Cash</span> 
                     <input type="radio" name="payment_type" value="cash" class="radio radio-accent"/>
                  </label>
               </div>
               <div class="form-control">
                  <label class="label cursor-pointer">
                     <span class="label-text">Voucher</span> 
                     <input type="radio" name="payment_type" value="voucher" class="radio radio-accent"/>
                  </label>
               </div>
            </section>
            <input type="hidden" name="status" value="not started">
         </form>
      </section>

      <section id="orderSummary" class="md:w-1/3">
         <h3 class="font-bold mb-5 text-accent text-xl md:text-2xl">Order Summary</h3>
         <section id="cartItems" class="flex flex-col gap-3 md:text-lg md:flex-wrap">
            <section class="flex flex-1 text-neutral-content gap-2">
                <section class="basis-1/2">
                    Product
                </section>
                <section class="basis-1/4 text-right">
                    Quantity
                </section>
                <section class="basis-1/4 text-right">
                    Price
                </section>
            </section>

            <template id="cartItemTemplate">
                <section class="flex flex-1 text-neutral-content gap-2">
                    <section id="product" class="basis-1/2">
                        Product
                    </section>
                    <section id="quantity" class="basis-1/4 text-right">
                        Quantity
                    </section>
                    <section id="price" class="basis-1/4 text-right">
                        Price
                    </section>
                </section>
            </template>
        </section>
        <div class="flex flex-row items-center justify-between mt-5 gap-2">
            <p class="text-lg text-accent basis-1/2">Total: $<span id="total">0</span></p>
            <button onclick="submitOrder()" class="btn btn-accent basis-1/3">Submit</button>
        </div>
      </section>
      
   </section>

   <dialog id="orderSuccess" class="modal">
      <div class="modal-box">
         <h3 class="font-bold text-lg text-success">Thank you for your order</h3>
         <p>Redirecting to the menu...</p>
      </div>
   </dialog>

   <?php include "helpers/api_calls.php" ?>

   <script>

      window.onload = () => {
         renderCart();
      }

      function renderCart() {
         const cart = document.querySelector("#cart");
         const cartItems = document.querySelector("#cartItems");
         const total = document.querySelector("#total");
         let orderItems = <?= session()->get('order_items') ?>;
         orderItems = orderItems.filter(item => 'menu_item_id' in item);
         let totalPrice = 0;

         orderItems.forEach(async item => {
               const itemContainer = cartItemTemplate.content.cloneNode(true).children[0];
               itemContainer.classList.remove('text-neutral-content')
               const product = itemContainer.querySelector("#product");
               const quantity = itemContainer.querySelector("#quantity");
               const price = itemContainer.querySelector("#price");

               const itemDetail = await get("menu_items", item.menu_item_id);

               product.innerText = itemDetail.name;
               quantity.innerText = item.quantity;
               price.innerText = `$${itemDetail.price}`;

               totalPrice += itemDetail.price * item.quantity;

               total.innerText = totalPrice;
               console.log(itemContainer)
               cartItems.appendChild(itemContainer);
         })

      }

      async function submitOrder() {
         const customerDetails = document.querySelector("#customerDetails");
         const total = document.querySelector("#total");
         let orderItems = <?= session()->get('order_items') ?>;
         details = orderItems.find(item => 'menuId' in item);
         orderItems = orderItems.filter(item => 'menu_item_id' in item);

         if (customerDetails.reportValidity()) {
               const formData = new FormData(customerDetails);
               const userDetails = Object.fromEntries(formData.entries());
               const payment_type = userDetails.payment_type;
               const status = userDetails.status;
               delete userDetails.payment_type;
               const totalPrice = total.innerText;
               const customer = await add('customers', userDetails);

               const order = {
                  customer_id: customer.id,
                  payment_type: payment_type,
                  // table is by default
                  table_num: 1,
                  status: status,
                  order_at: new Date().toISOString(),
                  total: totalPrice
               }

               const resultedOrder = await add('orders', order);

               orderItems.forEach(async item => {
                  const data = {
                     order_id: resultedOrder.id,
                     menu_item_id: item.menu_item_id,
                     quantity: item.quantity,
                     note: null
                  }

                  await add('order_items', data)
                  .then(data => console.log(data))
                  .catch(error => console.log(error))
               })

               orderSuccess.showModal();

               setTimeout(() => {
                  <?php session()->remove(['order_items']); ?>
                  location.replace(`<?= base_url("onlineorder/")?>${details.menuId}`)
               }, 2000);
               

         } else {
               return;
         }
      }

   </script>
<?= $this->endSection(); ?>
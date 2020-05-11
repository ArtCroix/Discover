<template>
  <form>
    <!--     <div class="form-group d-none">
      <label for="email">Email адрес</label>
      <input
        type="email"
        class="form-control"
        id="email"
        v-model="user_email"
        aria-describedby="emailHelp"
        placeholder="Введите email"
      />
    </div>-->
    <div class="form-group">
      <label
        for="name"
      >{{ current_locale == 'ru' ? 'Имя' : current_locale == 'en' ? 'Name' : 'Name' }}</label>
      <input
        type="text"
        v-model="user_name"
        class="form-control"
        id="name"
        placeholder="Введите имя"
      />
    </div>
    <div class="form-group">
      <label
        for="phone"
      >{{ current_locale == 'ru' ? 'Телефон' : current_locale == 'en' ? 'Phone' : 'Phone' }}</label>
      <input
        type="text"
        class="form-control"
        v-model="user_phone"
        id="phone"
        placeholder="Введите телефон"
      />
    </div>

    <button
      type="submit"
      id="pay_button"
      @click.prevent="pay"
      class="btn btn-primary"
    >{{ current_locale == 'ru' ? 'Оплатить' : current_locale == 'en' ? 'Pay' : 'Pay' }}</button>
  </form>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      user_name: "",
      user_email: this.email,
      user_phone: this.phone
    };
  },
  props: {
    email: "",
    price: "",
    phone: "",
    event_name: ""
  },
  computed: {
    ...mapState(["locales", "current_locale"]),
    receipt() {
      return {
        Items: [
          {
            label: `Организация тренировочного курса ${this.event_name}`,
            price: this.price,
            quantity: 1.0,
            amount: +this.price,
            measurementUnit: "шт"
          }
        ],
        calculationPlace: "https://test2.it-edu.com/?e=" + this.user_email,
        phone: this.user_phone,
        email: this.user_email
      };
    },
    options() {
      return {
        publicId: "pk_fbbc8fbf10a9deafcd574b15bc67f",
        description: `Организация тренировочного курса ${this.event_name}`,
        amount: +this.price,
        currency: "RUB",
        invoiceId: +new Date() + `${this.event_name}`,
        accountId: this.user_email,
        skin: "mini",
        data: {
          cloudPayments: {
            customerReceipt: this.receipt
          },
          name: this.user_name,
          phone: this.user_phone,
          email: this.user_email
        }
      };
    }
  },

  methods: {
    pay() {
      let widget = new cp.CloudPayments();
      widget.charge(
        this.options,
        function(options) {
          window.location.href = "/success_payment";
        },
        function(reason, options) {
          window.location.href = "/fail_payment";
        }
      );
    }
  },
  mounted() {
    console.log(this.price);
    const plugin = document.createElement("script");
    plugin.setAttribute(
      "src",
      "https://widget.cloudpayments.ru/bundles/cloudpayments"
    );
    plugin.async = true;
    document.head.appendChild(plugin);
  }
};
</script>

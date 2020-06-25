<template>
  <div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="currency">Выберите валюту</label>
        <select v-model="currency" name="currency" id="currency" class="form-control">
          <option disabled>Выберите валюту</option>
          <option value="rub">Рубли</option>
          <option value="usd">Доллары</option>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="price_type">Укажите тип</label>
        <select v-model="price_type" name="price_type" id="price_type" class="form-control">
          <option disabled>Укажите тип цены</option>
          <option value="full">Полная</option>
          <option value="partial">Частичная</option>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="date">Дата</label>
        <input
          v-model="date"
          name="date"
          type="text"
          placeholder="Образец: 2020-12-31"
          class="form-control"
          id="date"
        />
      </div>
      <div class="form-group col-md-3">
        <label for="price">Сумма</label>
        <input v-model="price" name="price" type="text" class="form-control" id="price" />
      </div>
      <button
        v-if="pl_key===''"
        :disabled="!addPriceEnabled"
        @click.prevent="addPrice"
      >Добавить цену</button>
      <button v-else @click.prevent="changePrice">Изменить цену</button>
      <div hidden class="form-group col-md-6">
        <input
          name="string_price"
          v-model="string_price"
          type="text"
          class="form-control"
          id="string_price"
        />
      </div>
    </div>Цены:
    <div :key="pl_key" v-for="(price,pl_key) in price_list">
      <div>
        Валюта: {{price["currency"]}} Тип: {{price["price_type"]}} Дата: {{price["date"]}} Сумма: {{price["price"]}}
        <button
          @click.prevent="deletePrice(pl_key)"
        >Удалить цену</button>
        <button
          @click.prevent="enableChangePrice(price['currency'],price['price_type'],price['date'],price['price'],pl_key)"
        >Изменить цену</button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      prices: JSON.parse(this.prices_json),
      string_price: "",
      price_list: [],
      currency: "",
      price_type: "",
      date: "",
      price: "",
      pl_key: "",
      delete_type: ""
    };
  },

  props: {
    prices_json: {
      default: "{}"
    }
  },

  computed: {
    ...mapState(["locales"]),
    addPriceEnabled() {
      return this.currency && this.price_type && this.date && this.price;
    }
  },

  methods: {
    //Создать объект цен из "плоского" двумерного массива
    priceToObject() {
      this.prices = {};
      this.price_list.forEach(price => {
        if (!this.prices[price["currency"]]) {
          this.prices[price["currency"]] = { [price["price_type"]]: {} };
        }

        if (!this.prices[price["currency"]][price["price_type"]]) {
          this.prices[price["currency"]][price["price_type"]] = {};
        }

        this.prices[price["currency"]][price["price_type"]][price["date"]] =
          price["price"];
      });
      this.string_price = JSON.stringify(this.prices);
    },

    // Создать объект и массив цен из полей формы
    addPrice() {
      if (!this.prices[this.currency]) {
        this.prices[this.currency] = { [this.price_type]: {} };
      }

      if (!this.prices[this.currency][this.price_type]) {
        this.prices[this.currency][this.price_type] = {};
      }

      this.prices[this.currency][this.price_type][this.date] = this.price;
      this.string_price = JSON.stringify(this.prices);

      this.price_list = this.createPriceList();
    },

    changePrice() {
      this.price_list[this.pl_key]["currency"] = this.currency;
      this.price_list[this.pl_key]["price_type"] = this.price_type;
      this.price_list[this.pl_key]["date"] = this.date;
      this.price_list[this.pl_key]["price"] = this.price;
      this.pl_key = "";
      this.currency = "";
      this.price_type = "";
      this.date = "";
      this.price = "";
      this.priceToObject();
      this.string_price = JSON.stringify(this.prices);
    },

    deletePrice(pl_key) {
      this.price_list.splice(pl_key, 1);
      this.priceToObject();
      this.string_price = JSON.stringify(this.prices);
    },

    enableChangePrice(currency, price_type, date, price, pl_key) {
      this.currency = currency;
      this.price_type = price_type;
      this.date = date;
      this.price = price;
      this.pl_key = pl_key;
    },

    //Создать объект цен из двумерного массива
    createPriceList() {
      let flat_price = [];
      let price_type = "";
      function isObject(obj) {
        return obj != null && obj.constructor.name === "Object";
      }

      function flatPrice(prices, currency) {
        for (let key in prices) {
          if (isObject(prices[key])) {
            price_type = key;
            flatPrice(prices[key], currency);
          } else {
            flat_price.push({
              currency,
              price_type,
              date: key,
              price: prices[key]
            });
          }
        }
      }

      let { rub, usd } = this.prices;
      flatPrice(rub, "rub");
      flatPrice(usd, "usd");
      return flat_price;
    }
  },

  mounted() {
    this.string_price = JSON.stringify(this.prices);
    this.price_list = this.createPriceList();
  }
};
</script>

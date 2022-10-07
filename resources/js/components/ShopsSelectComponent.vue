<template>
  <div class="row">
    <div class="col">
      <!--    <div :class="children.length ? 'col-md-6' : 'col-md-12'">-->
      <div class="form-group">
        <label for="shop_id" v-if="label">{{ label }}</label>
        <select name="shop_id"
                id="shop_id"
                class="form-control"
        >
          <option hidden value="">{{ placeholder }}</option>
          <option v-for="shop in shops.data"
                  :selected="shop.id == value"
                  :value="shop.id">{{ shop.name }}
          </option>
        </select>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "ShopsSelectComponent",
  props: {
    name: {
      required: false,
      type: String,
      default: 'shop_id'
    },
    label: {
      required: false,
      type: String,
      default: ''
    },
    placeholder: {
      required: false,
      type: String,
      default: ''
    },
    value: {
      required: false,
      type: String,
    },
  },
  data() {
    return {
      selected_value:'',
      loaded: false,
      shops: {
        data: [],
      },
      values: [],
      children: [],
    }
  },
  created() {
    axios.get('/api/shops').then(response => {
      this.shops = response.data;
      console.log(this.shops)
    })
  },
  methods: {
    getClassName(i) {
      let className = 'col-md-6';
      let lastIndex = this.children.length - 1;
      if (i === lastIndex && (this.children.length + 1) % 2) {
        className = 'col-md-12';
      }
      return className;
    }
  }
}
</script>

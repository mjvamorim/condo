module.exports = {
  env: {
    node: true,
  },
  extends: ["eslint:recommended", "plugin:vue/vue3-recommended", "prettier"],
  rules: {
    // override/add rules settings here, such as:
    // 'vue/no-unused-vars': 'error'
    "vue/multi-word-component-names": 0,
    "vue/valid-v-slot": [
      "error",
      {
        allowModifiers: true,
      },
    ],
    "vue/require-prop-types": 0,
    "vue/no-mutating-props": 0,
    "vue/no-template-shadow": 0,
  },
};

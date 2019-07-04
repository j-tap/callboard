<template lang="pug">
//- fieldset.typeahead-wrap(:disabled='!regionSelectedObj')
fieldset.typeahead-wrap
	VueBootstrapTypeahead(
		title='Начните вводить город'
		:data='addressesList'
		v-model='addressValue'
		:serializer='s => s.title'
		placeholder='Город'
		ref='typeahead'
		@input='getAddresses(generateList)'
		@hit='addressSelected = $event'
		data-vv-as='Город'
		data-vv-name='city'
		v-validate="'required|citySelected'"
		:inputClass="(errors.first('city')) ? 'typeahead is-invalid' : 'typeahead'"
		:class="(errors.has('city')) ? 'typeahead is-invalid' : 'typeahead'"
	)
	.invalid-feedback {{ errors.first('city') }}

</template>

<script>
import { Validator } from 'vee-validate'
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'

export default {
	components: {
		VueBootstrapTypeahead,
	},
	inject: ['$validator'],
	props: {
		cityName: String,
		err: Object
	},
	data() {
		return {
			kladr: null,
			addressesList: [],
			addressValue: '',
			addressSelected: {},
		}
	},
	computed: {},
	methods: {
		getAddresses (callback)
		{
			if (this.addressValue.length) {
				axios
				.get('/api/v1/kladr/place?query='+ this.addressValue)
				.then((resp) => {
					this.kladr = resp.data.data
					callback()
				})
				.catch((error) => {
					this.printErrorOnConsole(error)
				})
			}
		},
		generateList ()
		{
			if (this.kladr) {
				this.addressesList = []
				const cities = this.kladr.cities

				for (let i in cities) {
					const city = cities[i]
					city.title = this.getStringAddr(city)
					this.addressesList.push(city)
				}
			}
		},
		getStringAddr (city)
		{
			return city.name +', '+ city.region_name
		},
	},
	created () 
	{
		Validator.extend('citySelected', {
			getMessage: field => 'Необходимо выбрать город.',
			validate: value => this.addressSelected.id ? true : false
		})
	},
	mounted () {},
	watch: {
		cityName (newVal, oldVal)
		{
			this.addressValue = newVal
			this.getAddresses(() => {
				this.addressValue = this.kladr.cities[0].name // this.getStringAddr(this.kladr.cities[0])
				this.$refs.typeahead.inputValue = this.addressValue
				this.addressSelected = this.kladr.cities[0]
				this.$validator.validateAll()
			})
		},
		addressSelected (newVal, oldVal)
		{
			this.$emit('setCityEmit', newVal.id)
		},
	}
}
</script>
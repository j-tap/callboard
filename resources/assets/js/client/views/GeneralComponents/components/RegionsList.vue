<template lang="pug">
ul.cities-list
	li.cities-list-wide(v-if='cities')
		a( 
			@click='getRegions()'
			href='javascript:void(0)'
		) < назад

	li.cities-list-item
		b-button(variant='link' id='city-all' @click="selectCity(null, 'Россия')") Россия
	
	li.cities-list-item(
		v-for='city in cities'
	)
		b-button(variant='link' :id=`'city-'+ city.id` @click='selectCity(city.id, city.name)') {{city.name}}

	li.cities-list-item(
		v-for='region in regions'
	)
		b-button(variant='link' :id=`'region-'+ region.id` @click='selectRegion(region.id, region.name)') {{region.name}}

	li.cities-list-loading(v-if='loading')
		b-spinner(label='Загрузка...')

</template>

<script>

export default {
	data() {
		return {
			loading: false,
			regions: null,
			cities: null,
		}
	},
	methods: {
		getRegions ()
		{
			loading: true
			axios
			.get('/api/v1/kladr/regions/1').then((resp) => { // 1 - russia
				this.cities = null
				this.regions = resp.data.data
				loading: false
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
				loading: false
			})
		},
		getCities (regionId)
		{
			loading: true
			axios
			.get('/api/v1/kladr/cities/' + regionId).then((resp) => {
				this.regions = null
				this.cities = resp.data.data
				loading: false
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
				loading: false
			})
		},
		
		selectRegion (id, name)
		{
			this.getCities(id)
			return false
		},
		selectCity (id, name)
		{
			this.$emit('cityUpdate', {id, name})
			this.getRegions()
		},
	},
	mounted () 
	{
		this.getRegions()
	}
}
</script>

<style scoped lang="scss">
@import '../../../../../sass/base';

.cities-list {
	list-style: none;
	margin: 0;
	padding: 0;
	columns: 4;
	break-inside: avoid;
	column-gap: 3rem;

	@include media-breakpoint-down(lg) {
		columns: 3;
	}
	@include media-breakpoint-down(md) {
		columns: 2;
	}
	@include media-breakpoint-down(sm) {
		columns: 1;
	}

	&-item {
		width: 25%;
		margin-bottom: .7rem;
		
		@include media-breakpoint-down(lg) {
			width: 33.33%;
		}
		@include media-breakpoint-down(md) {
			width: 50%;
		}
		@include media-breakpoint-down(sm) {
			width: 100%;
		}
	}
	&-wide {
		width: 100%;
		margin-bottom: 1rem;
	}
	&-loading {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		width: auto;
		z-index: 2;
		background: #fff;
		display: flex;
		align-items: center;
		justify-content: center;
	}
}

</style>	
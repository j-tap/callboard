<template lang="pug">
ul.social-group
	li
		a.social-group__vk(href='https://vk.com/tamtem_b2b' target='_blank')
	li
		a.social-group__ok(href='https://ok.ru/group/54744477925527' target='_blank')
	li
		a.social-group__fb(href='https://www.facebook.com/ТамТем-417576149054496/' target='_blank')
	li
		a.social-group__in(href='https://www.instagram.com/tamtemb2b/' target='_blank')

</template>

<script>
export default {
	components: {},
	data () {
        return {}
	},
	methods: {},
	mounted () {}
};
</script>

<style scoped lang="scss">
@import '../../../../../sass/base';

.social-group {
	margin: 0 -.7rem;
	padding: 0;
	list-style: none;
	display: flex;
	flex-direction: row;

	li {
		margin: 0 .7rem;
		padding: 0;

		a {
			display: block;
			width: 3rem;
			height: 3rem;
			text-decoration: none;
			border-radius: $border-radius;
			background-size: auto 2.5rem;
			background-position: 50% 50%;
		}
	}
	&__vk {
		background-color: #2c7fcf;
		background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M12.785 16.241s.288-.032.436-.194c.136-.148.132-.427.132-.427s-.02-1.304.576-1.496c.588-.19 1.341 1.26 2.14 1.818.605.422 1.064.33 1.064.33l2.137-.03s1.117-.071.587-.964c-.043-.073-.308-.661-1.588-1.87-1.34-1.264-1.16-1.059.453-3.246.983-1.332 1.376-2.145 1.253-2.493-.117-.332-.84-.244-.84-.244l-2.406.015s-.178-.025-.31.056c-.13.079-.212.262-.212.262s-.382 1.03-.89 1.907c-1.07 1.85-1.499 1.948-1.674 1.832-.407-.267-.305-1.075-.305-1.648 0-1.793.267-2.54-.521-2.733-.262-.065-.454-.107-1.123-.114-.858-.009-1.585.003-1.996.208-.274.136-.485.44-.356.457.159.022.519.099.71.363.246.341.237 1.107.237 1.107s.142 2.11-.33 2.371c-.325.18-.77-.187-1.725-1.865-.489-.859-.859-1.81-.859-1.81s-.07-.176-.198-.272c-.154-.115-.37-.151-.37-.151l-2.286.015s-.343.01-.469.161C3.94 7.721 4.043 8 4.043 8s1.79 4.258 3.817 6.403c1.858 1.967 3.968 1.838 3.968 1.838h.957z' fill='%23FFF' fill-rule='evenodd'/%3E%3C/svg%3E");
	}
	&__ok {
		background-color: #ff8f3e;
		background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23FFF' fill-rule='evenodd'%3E%3Cpath d='M11.674 6.536a1.69 1.69 0 0 0-1.688 1.688c0 .93.757 1.687 1.688 1.687a1.69 1.69 0 0 0 1.688-1.687 1.69 1.69 0 0 0-1.688-1.688zm0 5.763a4.08 4.08 0 0 1-4.076-4.075 4.08 4.08 0 0 1 4.076-4.077 4.08 4.08 0 0 1 4.077 4.077 4.08 4.08 0 0 1-4.077 4.075zM10.025 15.624a7.633 7.633 0 0 1-2.367-.98 1.194 1.194 0 0 1 1.272-2.022 5.175 5.175 0 0 0 5.489 0 1.194 1.194 0 1 1 1.272 2.022 7.647 7.647 0 0 1-2.367.98l2.279 2.28a1.194 1.194 0 0 1-1.69 1.688l-2.238-2.24-2.24 2.24a1.193 1.193 0 1 1-1.689-1.689l2.279-2.279'/%3E%3C/g%3E%3C/svg%3E");
	}
	&__fb {
		background-color: #5788d0;
		background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M13.423 20v-7.298h2.464l.369-2.845h-2.832V8.042c0-.824.23-1.385 1.417-1.385h1.515V4.111A20.255 20.255 0 0 0 14.148 4c-2.183 0-3.678 1.326-3.678 3.76v2.097H8v2.845h2.47V20h2.953z' fill='%23FFF' fill-rule='evenodd'/%3E%3C/svg%3E");
	}
	&__in {
		background-color: #833AB4;
		background-image: url("data:image/svg+xml,%3Csvg data-name='Layer 21' height='24' id='Layer_21' fill='%23ffffff' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'%3E%3Ctitle/%3E%3Cpath d='M15.5,3h-7A5.5,5.5,0,0,0,3,8.5v7A5.5,5.5,0,0,0,8.5,21h7A5.5,5.5,0,0,0,21,15.5v-7A5.5,5.5,0,0,0,15.5,3Zm4,12.5a4.00454,4.00454,0,0,1-4,4h-7a4.00454,4.00454,0,0,1-4-4v-7a4.0045,4.0045,0,0,1,4-4h7a4.0045,4.0045,0,0,1,4,4Z'/%3E%3Cpath d='M12,7.5A4.5,4.5,0,1,0,16.5,12,4.5,4.5,0,0,0,12,7.5ZM12,15a3,3,0,1,1,3-3A3.0034,3.0034,0,0,1,12,15Z'/%3E%3Ccircle cx='16.70001' cy='7.29999' r='1'/%3E%3C/svg%3E");
	}
}
</style>

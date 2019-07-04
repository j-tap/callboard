<template lang="pug">
header.header
	nav.navbar.navbar-expand.navbar-light
		.container.position-relative
			router-link(
				:to="{name: 'bids.list', query: bidsQueryParam}" 
				class='flex-box f-align-center f-content-center logo'
			)
				logoheader

			b-btn(
				variant='light' 
				class='btn-categories' 
				v-b-toggle="'categoryToggle'"
			)
				span Категории
				feather(type='x' v-if='isCategoryCollapse')
				feather(type='list' v-else)

			.mx-auto.d-md-none.d-sm-block

			ul.navbar-nav.header-navbar-icons
				li.nav-item.nav-item-profile(v-if='$root.isAuth')
					a.nav-link.dropdown-toggle.header-user(
						href='javascript:void(0)' 
						role='button'
						title='Личный кабинет'
						v-b-toggle="'profileToggle'"
						@click='isProfileNoty = false'
					)
						.position-relative
							.header-user-ava
								img.rounded(
									v-if='$store.state.profile.profile.photo' 
									:src='$store.state.profile.profile.photo' 
									alt=' '
								)
								img(
									v-else 
									:src="'https://via.placeholder.com/80x80?text='+ $store.state.profile.profile.name.charAt(0)" 
									alt=' '
								)
							span.badge.badge-pill.badge-danger.align-top(v-if="false") &nbsp;
						feather(type='align-left')
						span.badge.badge-pill.badge-danger(
							v-if="$store.state.profile.unreadMsg"
						) &nbsp;

					a.nav-link.header-noty(
						href='javascript:void(0)' 
						role='button'  
						title='Уведомления'
						v-b-toggle="'profileToggle'"
						@click='isProfileNoty = true'
					)
						feather(type='bell')
						span.badge.badge-pill.badge-danger.align-top(v-if='$root.notification') &nbsp;

					a.pl-4.nav-link(
						v-if="isToggleVoply && $route.name !== 'home'"
						href='javascript:void(0)' 
						role='button'  
						title='Заявки о покупке'
						@click='toggleVoply()'
					)
						feather(type='volume-1')

				li.nav-item.pl-3(v-if='!$root.isAuth')
					b-btn(v-b-modal="'modalSignin'" variant='outline-primary' class='header-btn-login')
						span Регистрация
						span Войти

			.header-navbar-search
				Search(ref='searchComponent')

			ul.navbar-nav.header-navbar-btns
				li.nav-item
					router-link(
						v-if='$root.isAuth'
						:to="{name:'new.bid', params:{}}"
						class="btn btn-danger header-btn-newbid"
					) Добавить объявление
					b-btn(
						v-else
						v-b-modal="'modalSignin'" 
						variant='danger'
						class='header-btn-newbid'
					) Добавить объявление
					
			b-collapse(
				id='categoryToggle' 
				class='header-collapse header-collapse-categories' 
				v-click-outside='clickOutsideCategory' 
				v-model='isCategoryCollapse'
				ref='categoryToggle'
			)
				div
					CategoriesList(@categoryUpdate='categoryUpdate')

			b-collapse(
				v-if='$root.isAuth'
				id='profileToggle' 
				class='header-collapse header-collapse-profile' 
				v-click-outside='clickOutsideProfile' 
				v-model='isProfileCollapse'
				ref='profileToggle'
			)
				.header-collapse-profile-user
					.row.align-items-center
						.col
							UserInfo(
								v-if='$store.state.profile.profile.is_org_created'
								:user='$store.state.profile.profile'
							)
							UserInfo(
								v-else
								:user='$store.state.profile.profile'
							)
						.col-auto
							a.header-collapse-profile-user-noty(
								href='javascript:void(0)'
								:class='{active: isProfileNoty}'
								@click='toggleProfileNoty'
							)
								feather(type='bell')
								span.badge.badge-pill.badge-danger.align-top(v-if='$root.notification') &nbsp;

					.header-uid
						span.text-muted Ваш id: 
						span {{$store.state.profile.profile.unique_id}}

				.header-collapse-profile-noty(v-show='isProfileNoty')
					LkNotifications

				.header-collapse-profile-nav(
					@click='clickProfileNav'
					v-show='!isProfileNoty'
				)
					LkNavigation

	.header-search-sm
		//- Goback
		Search(ref='searchComponent')
		a.header-search-sm-btn-filter(
			href='javascript:void(0)'
			:class='{active: false}'
			@click='toggleFilterBids'
		)
			feather(type='sliders')

	b-modal#modalSignin(
		modal-class='modal-signin'
		size='lg'
		v-if='!$root.isAuth'
		ref='modalSignin'
	)
		LoginPopup(@hideModalSignin='hideModalSignin')
		div(slot='modal-footer')
	
</template>

<script>
import LoginPopup from "../../Auth/LoginPopup";
import LkNotifications from "../../LK/views/LkNotifications";
import Search from "./Search";
import CategoriesList from "./CategoryList";
import UserInfo from "../../GeneralComponents/components/UserInfo";
import LkNavigation from "../../LK/components/LkNavigation";
import Goback from "../../GeneralComponents/components/Goback";

export default {
	components: {
		LkNavigation,
		LoginPopup,
		LkNotifications,
		Search,
		CategoriesList,
		UserInfo,
		Goback
	},
	data() {
		return {
			isProfileNoty: false,
			isToggleVoply: false,
			isCategoryCollapse: false,
			isProfileCollapse: false,
			category: null,
			categoryId: null
		};
	},
	computed: {
		bidsQueryParam() {
			return {
				city: this.$store.state.city.id || "",
				type_deal: "sell",
				date_created: "desc"
			};
		}
	},
	methods: {
		hideModalSignin() {
			this.$refs.modalSignin.hide();
		},
		toggleProfileNoty() {
			this.isProfileNoty = !this.isProfileNoty;
		},

		clickOutsideCategory(evt, el) {
			if (
				this.isCategoryCollapse &&
				el.classList.contains("show") &&
				!$(evt.target).closest(".btn-categories").length
			) {
				this.isCategoryCollapse = false;
			}
		},
		categoryUpdate(category) {
			this.category = category.name;
			this.categoryId = category.id;
			this.isCategoryCollapse = false;
			this.$refs.searchComponent.beforeSubmit();
		},

		clickOutsideProfile(evt, el) {
			if (
				this.isProfileCollapse &&
				el.classList.contains("show") &&
				!$(evt.target).closest(".header-user").length &&
				!$(evt.target).closest(".header-noty").length
			) {
				this.isProfileCollapse = false;
			}
		},
		clickProfileNav(evt, el) {
			this.isProfileCollapse = false;
		},
		checkToggleVoply() {
			this.isToggleVoply = window.innerWidth <= 1750;
		},

		toggleVoply() {
			document.getElementById("voply").classList.toggle("active");
		},

		toggleFilterBids(evt) {
			document.getElementById("bidsFilter").classList.toggle("active");
		}
	},
	mounted() {
		$(".navbar-nav .dropdown-menu").click(evt => {
			if ($(evt.target).closest(".dropdown-profile-user-noty").length)
				return false;
		});

		this.checkToggleVoply();
		window.addEventListener("resize", () => {
			this.checkToggleVoply();
		});
	},
	watch: {}
};
</script>

<style lang="scss" scope>
@import "../../../../../sass/base.scss";

.height-gift ~ .header {
	top: $height-gift-height;

	@include media-breakpoint-down(sm) {
		top: $height-gift-height-sm;
	}

	.header-collapse:not(.header-collapse-profile) {
		max-height: calc(100vh - (#{$header-top-popover} + #{$height-gift-height}));

		@include media-breakpoint-down(sm) {
			max-height: calc(
				100vh - (#{$header-top-popover-sm} + #{$height-gift-height-sm})
			);
		}
	}
	.header-collapse-profile {
		max-height: calc(100vh - #{$height-gift-height});
	}
	&.header-bids-list {
		.header-collapse:not(.header-collapse-profile) {
			max-height: calc(
				100vh -
					(
						#{$header-top-popover} + #{$height-search-filter} + #{$height-gift-height}
					)
			);
		}
	}
}

.header-bids-list {
	.header-collapse:not(.header-collapse-profile) {
		top: ($header-top-popover + $height-search-filter);
		max-height: calc(
			100vh - (#{$header-top-popover} + #{$height-search-filter})
		);
	}
}

.header {
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	z-index: 999;
	padding: 0;
	height: $height-header;

	@include media-breakpoint-down(sm) {
		height: $height-header-sm;
	}

	.navbar {
		background: $light-gray;
		padding-left: 0;
		padding-right: 0;
		height: $height-header;

		@include media-breakpoint-down(sm) {
			height: auto;
		}

		.container {
			padding: 0 calc(#{$grid-gutter-width} / 2);
		}

		.logo {
			margin-left: 0;

			@include media-breakpoint-up(sm) {
				margin-right: 2rem;
			}
			@include media-breakpoint-down(sm) {
				max-width: 9rem;
			}
		}
		&-nav {
			align-items: center;
		}
		&-toggler {
			margin-left: 2rem;
			padding: 0;
			border: none;
		}
		.dropdown-menu {
			top: calc(100% + 1rem);
			box-shadow: $box-shadow-fx;
			padding: 0;
			border: none;
		}
		.dropdown-item {
			position: relative;
			padding: 0.6rem 1.5rem;

			& + .dropdown-item {
				border-top: 0.1rem solid $light;
			}
		}
		.badge {
			padding: 0;
			font-size: 1rem;
			border-radius: 50%;
			min-width: 1.6rem;
			height: 1.6rem;
			line-height: 1.6rem;
			position: absolute;
			top: -0.2rem;
			right: -0.2rem;
		}
		.btn,
		.form-control {
			line-height: 3rem;
			padding-top: 0;
			padding-bottom: 0;
			height: 3rem;
		}
		.btn {
			white-space: nowrap;
			font-size: ($font-size-base * 0.875);
		}
		.btn-categories {
			color: $text-gray;
			background: $white;

			@include media-breakpoint-down(md) {
				order: -1;
				background: transparent;
				padding: 0;
				border: none;
				margin-right: 2.5rem;
			}
			@include media-breakpoint-down(sm) {
				margin-right: 1rem;
			}

			&:hover,
			&:focus,
			&:active {
				box-shadow: none;
				background: $white;

				@include media-breakpoint-down(md) {
					background: transparent;
					border: none;
					box-shadow: none;
				}
			}

			span {
				position: relative;
				max-width: 17rem;
				display: inline-block;
				overflow: hidden;
				white-space: nowrap;
				padding-right: 1rem;
				vertical-align: middle;

				@include media-breakpoint-down(md) {
					display: none;
				}
			}
			i.feather {
				width: 2rem;
				height: 2rem;
				vertical-align: middle;
				color: inherit;

				@include media-breakpoint-down(md) {
					width: 2.4rem;
					height: 2.4rem;
					color: $primary;
				}
			}
		}
		.header-btn-newbid {
		}
		.header-btn-login {
			padding-left: 1rem;
			padding-right: 1rem;

			span + span {
				padding-left: 1rem;

				&::before {
					content: "";
					display: inline-block;
					padding-right: 1rem;
					vertical-align: middle;
					height: 2.5rem;
					border-left: 0.1rem dashed;
				}
			}
		}
	}

	&-uid {
		white-space: nowrap;
	}
	&-navbar-search {
		@include media-breakpoint-up(lg) {
			padding-right: 1.5rem;
			width: 100%;
			max-width: 45rem;
		}
		@include media-breakpoint-down(md) {
			margin-right: auto;
		}
		@include media-breakpoint-down(sm) {
			display: none;
		}
	}
	&-search-sm {
		display: none;
		padding: 1rem;
		background: $white;
		align-items: center;
		justify-content: space-between;
		flex-wrap: nowrap;

		@include media-breakpoint-down(sm) {
			display: flex;
		}

		.form-search[class] {
			margin: 0;
			width: 100%;

			.input-group {
				input.form-control {
					max-width: 100%;
					height: 2.8rem;
					line-height: 2.8rem;
				}
				.search-btn-submit,
				.search-btn-city {
					height: 2.8rem;
					line-height: 1rem;
					padding-top: 0;
					padding-bottom: 0;
				}
			}
		}
		&-btn-filter {
			margin-left: 1rem;

			.feather {
				vertical-align: middle;
			}
		}
		.goback {
			margin-right: 1rem;
			position: relative;
			left: auto;

			a {
				border-width: 0.1rem;
				width: 3.4rem;
				height: 2.8rem;
			}
		}
	}
	&-navbar-btns {
		margin-right: auto;

		@include media-breakpoint-down(md) {
			display: none;
		}
	}
	& &-navbar-icons {
		flex-direction: row;

		@include media-breakpoint-up(md) {
			order: 12;
		}

		.nav-item {
			@include media-breakpoint-up(sm) {
				margin-left: 1.4rem;
			}

			&-profile {
				display: flex;
				align-items: center;
			}
		}
		.nav-link {
			position: relative;
			height: 100%;
			line-height: 0;
			padding: 0.5rem;

			&.header-user {
				padding-top: 0;
				padding-bottom: 0;
			}
			&.header-noty {
				padding-left: 1.5rem;

				@include media-breakpoint-down(md) {
					padding-left: 0;
				}
			}
		}
		i.feather {
			height: 2.2rem;
			width: 2.2rem;
			vertical-align: middle;

			&--bell {
				@include media-breakpoint-down(md) {
					height: 1.7rem;
					width: 1.7rem;
				}
			}
		}
		.dropdown-menu {
			position: absolute;
		}
		.badge {
			box-shadow: 0 0 0.6rem 0 $danger;
			min-width: 1rem;
			width: 1rem;
			height: 1rem;
		}
	}
	&-user {
		display: flex;
		align-items: center;

		.row-icon {
			& > .feather:last-child {
				margin-left: 0.2rem;
			}
		}

		&-ava {
			overflow: hidden;
			width: 3.5rem;
			height: 3.5rem;
			border-radius: $border-radius-sm;

			@include media-breakpoint-down(sm) {
				width: 3rem;
				height: 3rem;
			}

			img {
				width: 100%;
				height: 100%;
			}
			.v-icon {
				font-size: 3.5rem;

				@include media-breakpoint-down(sm) {
					font-size: 3rem;
				}
			}
		}
	}
	.navbar-collapse {
		margin-right: auto;
	}
	&-collapse {
		width: auto;
		position: absolute;
		top: $header-top-popover;
		left: 0.5rem;
		right: 0.5rem;
		background: $white;
		box-shadow: $box-shadow;
		padding: 0;
		max-height: calc(100vh - #{$header-top-popover});
		overflow: hidden;
		z-index: 4;

		@include media-breakpoint-down(sm) {
			top: $header-top-popover-sm;
			max-height: calc(100vh - #{$header-top-popover-sm});
		}

		& > * {
			padding: 3rem;

			@include media-breakpoint-down(sm) {
				padding: 1.5rem;
			}
		}

		&.show {
			overflow-y: auto;
		}

		&-categories {
			height: 57rem;

			&.show {
				overflow-y: hidden;
			}
		}
		&-profile {
			border-radius: $border-radius;
			top: -1rem;
			right: 0;
			left: auto;
			width: 30rem;
			padding: 0;
			max-height: 100vh;

			@include media-breakpoint-down(md) {
				width: 100vw;
				right: calc(-#{$grid-gutter-width} / 2);
				border-radius: 0;
				top: calc(#{$height-header} - 1rem);
				max-height: 100vh;
				height: calc(100vh - #{$height-header});
			}
			@include media-breakpoint-down(sm) {
				top: calc(#{$height-header-sm} - 1rem);
				height: calc(100vh - #{$height-header-sm});
			}

			&-user {
				padding: 1.5rem;

				@include media-breakpoint-down(md) {
					display: none;
				}

				.user-info {
					align-items: center;

					.user-info-ava,
					&-ava {
						width: 6rem;
						height: 6rem;
						flex-basis: 6rem;
					}
				}
				&-noty {
					color: $secondary;

					&.active {
						color: $primary;
					}
				}
				.header-uid {
					font-size: 1.4rem;
					display: block;
					margin-top: 1.5rem;
				}
			}
			&-noty {
				background: $body-bg;
				border-radius: 0 0 1rem 1rem;
				padding: 1rem 1.6rem;
			}
			&-nav {
				background: $body-bg;
				border-radius: 0 0 1rem 1rem;
				padding: 0;

				.lk-nav {
					li {
						a {
							line-height: 1;
							color: $secondary;
							font-size: 1.6rem;
							padding: 1rem 1.5rem;
							transition: color 0.2s ease, background 0.2s ease;

							@include media-breakpoint-down(md) {
								padding-left: 5rem;
								padding-right: 5rem;
							}

							&.active,
							&:hover {
								color: $primary;
								background: transparent;
							}
							&:focus {
								color: $primary;
								background: $gray;
							}
							&.active:focus {
								color: $primary;
								background: $gray;
							}
							.badge {
								position: absolute;
								top: 50%;
								right: 1rem;
								margin-top: -0.8rem;
							}
						}
					}
				}
			}
		}
		.categories-list {
		}
		.subcategories {
		}
	}
}
</style>
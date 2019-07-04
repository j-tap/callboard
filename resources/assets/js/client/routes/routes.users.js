import UsersList from '../views/Users/views/List'
import UsersProfile from '../views/Users/views/Profile'

const routes = [
    {
        path: '/users',
        name: 'users.list',
        component: UsersList,
		meta: {
			title: `${APPNAME} - Список пользователей`,
		},
    },
	{
        path: '/users/:id',
        name: 'users.profile',
        component: UsersProfile,
		meta: {
			title: `${APPNAME} - Страница пользователя`,
		},
    },
]

export default routes
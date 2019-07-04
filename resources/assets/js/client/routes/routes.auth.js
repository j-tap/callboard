// Register
import RegisterForm from '../views/Auth/RegisterForm'
import RegisterConfirm from '../views/Auth/RegisterConfirm'
import RegisterSuccess from '../views/Auth/RegisterSuccess'
import PasswordRessetSuccess from '../views/Auth/PasswordRessetSuccess'

const routes = [
  {
    path: '/',
	name: 'register.form',
    component: RegisterForm,
    meta: {
      title: `${APPNAME} - Регистрация`,
    }
  }, 
  {
    path: '/confirm',
    name: 'register.confirm',
    component: RegisterConfirm,
    meta: {
      title: `${APPNAME} - Подтверждение регистрации`,
    }
  },
  {
    path: '/success-email',
    name: 'register.success',
    component: RegisterSuccess,
    meta: {
      title: `${APPNAME} - Регистрации успешна`,
    }
  },
  {
    path: '/success-reset',
    name: 'password.reset',
    component: PasswordRessetSuccess,
    meta: {
      title: `${APPNAME} - Сбросс пароля успешен`,
    }
  },
]

export default routes;
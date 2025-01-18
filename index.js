import { Liquid } from 'liquidjs'
import express from 'express'
import * as path from "node:path";
import session from 'express-session';
import dbUtils from './utils/db.js';
import 'dotenv/config';
import User from "./models/user.js";


(async function initDb() {
    try {
        await dbUtils.initializeDbModels();
    } catch (e) {
        console.log('COULD NOT CONNECT TO THE DB, retrying in 5 seconds');
        setTimeout(initDb, 5000);
    }
})();

const engine = new Liquid()
const app = express()

const port = process.env.APP_PORT || 80

app.engine('liquid', engine.express());
app.set('views', './views');
app.set('view engine', 'liquid');
app.use(express.static(path.join('views')));

app.use(session({
    secret: process.env.SECRET || 'secret',
    resave: false,
    saveUninitialized: true,
}))

app.use(express.urlencoded({extended: true}));

function auth(req, res, next) {
    if (req.session.user) {
        next();
    } else {
        res.redirect('login');
    }
}
app.get('/login', async (req, res) => {
    res.render('login')
})
app.post('/login', async (req, res) => {
    if (req.body.login && req.body.password) {
        const user = await User.findOne({where: {login: req.body.login, password: req.body.password}})
        if (user){
            req.session.user = {
                login: req.body.login,
            };
            console.log(req.session.user)
            res.redirect('/')
            return
        }
    }
    res.redirect('login')
})

app.get('/', auth, async (req, res) => {
    res.render('main')
})

app.listen(port);



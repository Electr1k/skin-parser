import User from './user.js';
import {Sequelize} from "sequelize";
import 'dotenv/config';


const { DB_USER, DB_PASSWORD, DB_HOST, DB_PORT, DB_NAME } = process.env;

console.log(DB_PORT)
export const models = {
    User
};

export const sequelize = new Sequelize(DB_NAME, DB_USER, DB_PASSWORD, {
    host: DB_HOST,
    port: 5432,
    dialect: 'postgres',
    logging: false,
});

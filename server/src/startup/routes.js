const express = require('express'); //import express

const router  = express.Router();

const appController = require('../controllers/app');

//APP
router.get('/', appController.app);


module.exports = router;
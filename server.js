const express = require('express');
const bodyParser = require('body-parser');

const app = express();
const port = 3000;

app.use(bodyParser.json());
app.use(express.static('public'));

let messages = [];

app.get('/messages', (req, res) => {
    res.json(messages);
});

app.post('/messages', (req, res) => {
    const { text } = req.body;
    if (text) {
        messages.push({ text });
        res.status(201).send('留言已儲存');
    } else {
        res.status(400).send('留言不能為空');
    }
});

app.listen(port, () => {
    console.log(`留言板伺服器啟動於 http://localhost:${port}`);
});
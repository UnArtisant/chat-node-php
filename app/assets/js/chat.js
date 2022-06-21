import alpine from "alpinejs";
import {addToUrl, getParamsUrl} from "./helper/url";
import axios from "axios";

export const CONVERSATION_KEY = "conversation"

async function fetchMessages(id) {
    try {
        return await axios.get(`https://localhost:8000/api/conversation/${id}/messages`).then(r => r.data)
    } catch (e) {
        switch (e.response?.data) {
            case "access_denied" :
                console.log("access denied")
                break;
            case "not_connected" :
                console.log("you're not connected")
                break;
            case "no_conversation" :
                console.log("no conversation")
                break;
            default :
                console.log("something went wrong")
                break;
        }
        return null
    }
}


async function select_conversation(conversation) {
    this.message = ""
    this.messages_loading = true
    const messages = await fetchMessages(conversation)
    if (!messages.length) {
        this.conversation = null
    } else {
        this.conversation = {
            id: conversation,
            messages
        }
    }
    this.messages_loading = false
    addToUrl(CONVERSATION_KEY, conversation)
}

function handle_message(e) {
    const el = e.target
    this.message = el.value
}

async function handle_submit(e) {
    e.preventDefault()
    try {
        const message = await axios.post(`https://localhost:8000/api/messages`, {
            content: this.message,
            conversation : this.conversation.id
        }).then(r => r.data)
        this.message = ""
        return message
    } catch (e) {
        console.log(e)
        switch (e.response?.data) {
            case "access_denied" :
                console.log("access denied")
                break;
            case "not_connected" :
                console.log("you're not connected")
                break;
            case "no_conversation" :
                console.log("no conversation")
                break;
            default :
                console.log("something went wrong")
                break;
        }
        return null
    }
}

/**
 * @return {
 *   {
 *     conversation: ?Object,
 *     select_conversation: function
 *   }
 * }
 * */
function chat() {
    return {
        conversation: null,
        message: "",
        messages_loading: false,
        select_conversation,
        handle_message,
        handle_submit
    }
}

window.data_chat = chat

window.Alpine = alpine
alpine.start()
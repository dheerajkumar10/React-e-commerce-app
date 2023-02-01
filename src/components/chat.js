import React from 'react'
import { Link } from 'react-router-dom';

export default function Chat() {
    var style = { margin: '20px' };
    return (
        <main style={{ textAlign: 'center' }}>
            <div className='chat'>
                <iframe className='chat-panel' src="http://localhost:4444/"></iframe>
            </div>
        </main>

    )
}

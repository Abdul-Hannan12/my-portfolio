let projects = [
    {
        "id": 1,
        "type": "App",
        "title": "Notes App",
        "desc": `
        The Notes App is a native Android application developed using Java. It provides a convenient way to create, edit, and delete notes on your mobile device. With a user-friendly interface and local storage using Room database, this app allows you to easily manage your personal notes.
        <br><br>
        Effortlessly capture your thoughts, ideas, and important information using the Notes App. Add new notes, edit existing ones, and remove unnecessary entries with a simple and intuitive interface. Stay organized and keep your thoughts in one place using this lightweight and efficient Android application.
        `,
        "img": "images/projects/app/notes_app.png",
        "url": ""
    },
    {
        "id": 2,
        "type": "App",
        "title": "Complaint Management System",
        "desc": `
        The Complaint Management System is a Flutter-based Android application developed specifically for university settings. It offers a streamlined process for students to register complaints and enables administrators to efficiently manage and address those complaints. With separate user and admin sides, this application ensures a smooth experience for both parties involved.
        <br><br>
        Students can create an account and log in to the application. Upon logging in, they can view their personal details and check the status of their registered complaints. The student dashboard provides an intuitive interface for easy navigation. Students can register complaints using a floating action button, ensuring a quick and straightforward process.
        <br><br>
        On the admin side, administrators have access to an overview of complaint categories. Within each category, administrators can view all complaints registered by students and take appropriate actions. This includes reviewing complaints, adding comments, and updating the status of each complaint, such as marking them as "in progress," "rejected," "approved," or "resolved."
        <br><br>
        To ensure seamless functionality, the Complaint Management System leverages Firebase as its backend. Specifically, Firebase Authentication (Firebase Auth) is utilized for user authentication, and Firebase Firestore is employed for efficient data storage and retrieval.
        <br><br>
        Experience an efficient and effective system for managing and resolving complaints within a university environment with the Complaint Management System.
        `,
        "img": "images/projects/app/cms.png",
        "url": ""
    },
    {
        "id": 3,
        "type": "App",
        "title": "Admin Dashboard",
        "desc": `
        The Admin Dashboard is a Flutter-based application designed for managing a delivery company's operations. It serves as a central hub for monitoring and overseeing various aspects of the business. Built with a user-friendly interface, it offers features such as login functionality, displaying available drivers and clients, and presenting revenue data through charts.
        <br><br>
        This dashboard, backed by a Node.js backend, provides administrators with essential insights and control over the company's operations. It allows administrators to log in securely and access real-time information about drivers and clients. The availability of drivers and clients can be easily viewed, enabling efficient assignment and coordination of tasks.
        <br><br>
        The backend of the dashboard utilizes MongoDB, a popular NoSQL database, to store and manage data efficiently.
        `,
        "img": "images/projects/app/dashboard.png",
        "url": ""
    },
    {
        "id": 4,
        "type": "App",
        "title": "BMI Calculator",
        "desc": `
        The BMI Calculator is a flutter-based application that allows users to calculate their Body Mass Index (BMI) quickly and easily. By inputting their height and weight, users can obtain their BMI value, which is a measure of body fat based on these parameters. This simple and intuitive tool provides users with a basic assessment of their overall body composition and can be used as a starting point for monitoring their health and fitness goals.
        `,
        "img": "images/projects/app/bmi.png",
        "url": ""
    },
    {
        "id": 5,
        "type": "App",
        "title": "Random Chatting App",
        "desc": `
        The Random Chatting App is a native Android application developed using Java. It leverages Firebase Authentication and Firestore to provide a seamless and secure user experience. With this app, users can create accounts, log in, and connect with random users from around the world for chatting.
        <br><br>
        The app offers a simple and intuitive interface that allows users to find and initiate conversations with other random users. By leveraging the power of Firebase Cloud Messages, users can receive notifications to stay updated on new messages and stay connected.
        <br><br>
        Discover new connections and engage in conversations with people from different parts of the world through the Random Chatting App. Enjoy the thrill of meeting new people and expanding your social network, all within a secure and user-friendly mobile application.
        `,
        "img": "images/projects/app/chat_app.png",
        "url": ""
    },
    {
        "id": 6,
        "type": "App",
        "title": "Dr Phone",
        "desc": `
        Dr Phone is a native Android application developed in Java that allows users to fetch and view detailed information about their mobile devices. With this app, users can access vital device information, ensuring everything is functioning correctly. Additionally, Dr Phone provides the functionality to test various sensors available on the phone.
        `,
        "img": "images/projects/app/dr_phone.png",
        "url": ""
    },
    {
        "id": 7,
        "type": "App",
        "title": "Fly Bird",
        "desc": `
        Fly Bird is an engaging 2D game developed in native Java for Android. In this game, players control a bird character by holding down on the screen, allowing it to navigate through obstacles and earn points. The game also incorporates features such as recording the player's score and storing the high score achieved.
        <br><br>
        Immerse yourself in the colorful and captivating world of Fly Bird. Challenge your reflexes and coordination as you guide the bird through a series of challenging obstacles. With lively background music, the game offers an enjoyable and immersive gaming experience for players of all ages.
        `,
        "img": "images/projects/app/fly_bird.png",
        "url": ""
    },
    {
        "id": 8,
        "type": "App",
        "title": "Music Player",
        "desc": `
        The Music Player is a native Java Android application designed to provide a seamless music playback experience. This lightweight and intuitive app allows users to enjoy their MP3 files stored on the device's internal and external storage.
        <br><br>
        With the Music Player, users can easily navigate through their music library and access essential playback controls. The app features functions such as play, pause, skip to the next track, go back to the previous track, and the ability to skip forward or backward by 10 seconds for precise audio control.
        `,
        "img": "images/projects/app/music_player.png",
        "url": ""
    },
    {
        "id": 9,
        "type": "App",
        "title": "Rox",
        "desc": `
        Rox is an innovative Flutter application that utilizes the power of artificial intelligence to provide conversational interactions with users. With Rox, users can input their queries or commands using text or voice input and receive intelligent responses in return. This application acts as an AI assistant that can answer questions, engage in conversations, and provide helpful information.
        <br><br>
        Behind the scenes, Rox leverages OpenAI's API to generate responses based on user prompts. By integrating AI capabilities, Rox can provide dynamic and contextually relevant answers, making the user experience more interactive and engaging. Additionally, Rox has the capability to generate images, further enhancing the visual elements of the app.
        `,
        "img": "images/projects/app/rox.png",
        "url": ""
    },
    {
        "id": 10,
        "type": "App",
        "title": "Tic Tac Toe",
        "desc": `
        Tic Tac Toe is a classic native Android game developed in Java that offers endless hours of fun and strategic gameplay. This popular game is designed for two players, allowing them to compete against each other on a virtual grid.
        <br><br>
        With Tic Tac Toe, players take turns placing their respective symbols, typically "X" and "O," on a 3x3 grid. The objective is to form a straight line of three symbols horizontally, vertically, or diagonally. Players must think strategically to block their opponent's moves while attempting to create their winning combinations.
        <br><br>
        The game features a user-friendly interface, intuitive controls, and delightful visuals that enhance the overall gaming experience. Whether you're a seasoned player or new to the game, Tic Tac Toe offers an engaging and competitive environment for players of all ages.
        `,
        "img": "images/projects/app/tic_tac_toe.png",
        "url": ""
    },
    {
        "id": 11,
        "type": "Web",
        "title": "Cipher",
        "desc": `
        Cipher is a versatile web-based application designed to provide secure encryption and decryption functionality for both text and images. With Cipher, users can safeguard their sensitive data and communicate securely.
        <br><br>
        This application offers two primary options: encryption and decryption. Users can input their desired text or upload an image file to apply the encryption algorithm, which transforms the data into a coded format, rendering it unreadable to unauthorized individuals. Conversely, the decryption option allows users to reverse the process and restore the original content from the encrypted data.
        `,
        "img": "images/projects/web/cipher.png",
        "url": ""
    },
    {
        "id": 12,
        "type": "Web",
        "title": "Password Generator",
        "desc": `
        The Simple Password Generator is a user-friendly web-based application designed to create passwords quickly and easily. With this tool, users can generate passwords of varying strengths to enhance their online security.
        <br><br>
        This straightforward app provides four distinct options for password generation: "Super Strong," "Strong," "Weak," and "Funny." Users can select their preferred strength level based on their specific requirements and preferences.
        `,
        "img": "images/projects/web/pw_gen.png",
        "url": ""
    },
    {
        "id": 13,
        "type": "Web",
        "title": "PDF Merger",
        "desc": `
        The PDF Merger is a convenient web-based application that simplifies the process of merging multiple PDF files into a single, cohesive document. With this user-friendly tool, combining and organizing PDFs becomes effortless and efficient.
        <br><br>
        Using the PDF Merger is straightforward. Users can upload two or more PDF files from their local storage directly through the web app's intuitive interface. The application then processes the uploaded files and merges them seamlessly into a unified PDF document.
        `,
        "img": "images/projects/web/pdf_merger.png",
        "url": ""
    },
    {
        "id": 14,
        "type": "Web",
        "title": "Chat App",
        "desc": `
        The Chat App is an interactive web-based group chatting application that facilitates seamless communication among users in real-time. Powered by Socket.IO, this application enables users to engage in instant messaging and establish connections with individuals or groups.
        `,
        "img": "images/projects/web/chat_app.png",
        "url": ""
    },
    {
        "id": 15,
        "type": "Web",
        "title": "Color",
        "desc": `
        This is a versatile web application designed to assist users in exploring, generating, and converting colors. With this intuitive tool, users can effortlessly generate random colors, obtain color codes or RGB values, and convert between hexadecimal (hex) and RGB color representations.
        <br><br>
        This web app offers multiple functionalities, empowering users to unleash their creativity and effectively work with colors
        `,
        "img": "images/projects/web/color.png",
        "url": ""
    },
    {
        "id": 16,
        "type": "Design",
        "title": "Colorization",
        "desc": ``,
        "img": "images/projects/design/color.jpeg",
        "url": ""
    },
    {
        "id": 17,
        "type": "Design",
        "title": "Restoration",
        "desc": ``,
        "img": "images/projects/design/restoration.jpeg",
        "url": ""
    },
    {
        "id": 18,
        "type": "Design",
        "title": "Tracing",
        "desc": ``,
        "img": "images/projects/design/tracing.jpeg",
        "url": ""
    },
    {
        "id": 19,
        "type": "Other",
        "title": "Flutter Package - Responsive Size Widget",
        "desc": `
        The "responsive_size_widget" is a Flutter package that simplifies the creation of responsive layouts by providing easy-to-use widgets and functions for sizing based on screen dimensions. With this package, developers can effortlessly adapt their UI elements to different screen sizes, ensuring a consistent and optimized user experience across devices. Whether it's adjusting widget sizes or handling layout changes, the "responsive_size_widget" package offers a seamless solution for building responsive Flutter applications.
        `,
        "img": "images/projects/other/responsive_pkg.png",
        "url": "https://pub.dev/packages/responsive_size_widget"
    },
    {
        "id": 20,
        "type": "Other",
        "title": "Bulk Rename Desktop Utility",
        "desc": `
        The Bulk Rename Utility is a powerful command-line tool developed using Node.js, designed to streamline and automate the process of renaming multiple files and directories simultaneously. This utility offers a convenient solution for efficiently managing file names by allowing users to specify renaming patterns, search for specific parts, and replace them with desired alternatives.
        <br><br>
        With the Bulk Rename Utility, users can effortlessly rename a large number of files or directories with just a few simple steps. 
        `,
        "img": "images/projects/other/rename.png",
        "url": "https://github.com/Abdul-Hannan12/bulk-rename"
    },
]

let default_language = 'en'
let preferred_language

const nature_photos = [
  votdvars.pluginUrl + 'images/mountain4.webp',
  votdvars.pluginUrl + 'images/river2.webp',
  votdvars.pluginUrl + 'images/waterfall1.webp',
  votdvars.pluginUrl + 'images/farm1.webp',
  votdvars.pluginUrl + 'images/caribbean1.webp',
  votdvars.pluginUrl + 'images/caribbean2.webp',
  votdvars.pluginUrl + 'images/bahamas1.webp',
  votdvars.pluginUrl + 'images/bahamas2.webp',
  votdvars.pluginUrl + 'images/farm2.webp',
  votdvars.pluginUrl + 'images/rainbow1.webp',
  votdvars.pluginUrl + 'images/desert1.webp',
  votdvars.pluginUrl + 'images/desert2.webp',
  votdvars.pluginUrl + 'images/mountain5.webp',
  votdvars.pluginUrl + 'images/garden1.webp',
  votdvars.pluginUrl + 'images/spanish1.webp',
  votdvars.pluginUrl + 'images/prairie1.webp',
  votdvars.pluginUrl + 'images/northpole1.webp',
];
const verses = [
  //Top 10 Searched
  'For God so loved the world, that he gave his only begotten Son, that whosoever believeth in him should not perish, but have everlasting life. - Jhn 3:16 KJV',
  'For I know the thoughts that I think toward you, saith the LORD, thoughts of peace, and not of evil, to give you an expected end. - Jer 29:11 KJV',
  'I can do all things through Christ which strengtheneth me. - Phl 4:13 KJV',
  'Fear thou not; for I am with thee: be not dismayed; for I am thy God: I will strengthen thee; yea, I will help thee; yea, I will uphold thee with the right hand of my righteousness. - Isa 41:10 KJV',
  'Trust in the LORD with all thine heart; and lean not unto thine own understanding. In all thy ways acknowledge him, and he shall direct thy paths. - Pro 3:5-6 KJV',
  'And we know that all things work together for good to them that love God, to them who are the called according to his purpose. - Rom 8:28 KJV',
  'Yea, though I walk through the valley of the shadow of death, I will fear no evil: for thou art with me; thy rod and thy staff they comfort me. - Psa 23:4 KJV',
  'And be not conformed to this world: but be ye transformed by the renewing of your mind, that ye may prove what is that good, and acceptable, and perfect, will of God. - Rom 12:2 KJV',
  'But they that wait upon the LORD shall renew their strength; they shall mount up with wings as eagles; they shall run, and not be weary; and they shall walk, and not faint. - Isa 40:31 KJV',
  'Be careful for nothing; but in every thing by prayer and supplication with thanksgiving let your requests be made known unto God. - Phl 4:6 KJV',
  
  //Top 11-21
  

]

function parseTranslatedHTML(verse, translated_data){
  let translated_verse
  if(translated_data!=='default') translated_verse=translated_data?.translated_verse
  else translated_verse='default'
  
  let verse_content = document.querySelector('#verse-content')
  let nature_photo = document.querySelector('#nature-photo')

  if(verse_content){
    if(translated_verse && translated_verse !== 'default')
    { 
      verse_content.textContent = translated_verse
      console.log(translated_verse)
    }
    else
    {
       verse_content.textContent = verse
       console.log(verse)
    }
    nature_photo.src = votdgetRandomNaturePhoto()
  }

}

function showVerse(data){
  let verse = ''
  verse = data
  
  votddisplayVerse(verse?.random_verse)
}

async function translateVerse(data){
  let verse = data?.random_verse
  let translated_data
  if(preferred_language!==default_language && preferred_language!=='en'){
    let res = await fetch(`https://www.freesmartphoneapps.com/verseoftheday/api/translate-verse?lang=${preferred_language}&verse=${verse}`)
    translated_data = await res.json()
  }
  else{
    console.log('translated_data=default, fetching skipped')
    translated_data='default'
  }
  
  parseTranslatedHTML(verse, translated_data)
}

async function votdfetchVerse() {
  let res = await fetch(`https://www.freesmartphoneapps.com/verseoftheday/api/`)
  let data = await res.json()
  translateVerse(data)
}

function votdchooseLanguage(default_language) {
  preferred_language = votdvars.language || default_language
}

function votdgetRandomVerse(){
  const versesIndex = Math.round(Math.random() * (verses?.length-1))
  const verse = verses[versesIndex]
  return verse
}

function votdgetRandomNaturePhoto() {
  const random_index = Math.floor(Math.random() * nature_photos?.length);
  return nature_photos[random_index];
}

function votddisplayVerse(verse) {
  document.getElementById('verse-content').textContent = verse;
  document.getElementById('nature-photo').src = votdgetRandomNaturePhoto();
}

document.addEventListener("DOMContentLoaded", function() {
 //preferred_language = localStorage.getItem('preferred_language', preferred_language) || 'en'
 // Fetch and display the verse (your verse-fetching logic)
 votdchooseLanguage(default_language)
 votdfetchVerse();
});
/*
 * No data is saved to the block. Data is saved to post meta via attributes.
 *
 * Because this is similar to a dynamic block it doesn’t need to override the
 * default save implementation on the client. Instead, it needs a server
 * component. The contents in the front of your site depend on the function
 * called by the `render_callback` property of `register_block_type`.
 */
export default function save() {
	return null;
}
